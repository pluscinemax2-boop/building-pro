<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Building;
use App\Services\RazorpayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected RazorpayService $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    /**
     * Show subscription checkout page
     */
    public function showCheckout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'building_id' => 'required|exists:buildings,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $building = Building::findOrFail($request->building_id);

        // Verify building belongs to authenticated user (for building admins) or user is Admin
        $user = Auth::user();
        if ($user->role_id !== 1 && $building->building_admin_id !== $user->id) {
            abort(403, 'Unauthorized access to this building');
        }

        // Calculate amount based on plan
        $units = $plan->billing_type === 'per_flat' ? ($building->flats()->count() ?? 1) : 1;
        $amount = $plan->price * $units;

        return view('payments.checkout', [
            'plan' => $plan,
            'building' => $building,
            'amount' => $amount,
            'units' => $units,
            'razorpayKeyId' => $this->razorpay->getKeyId(),
        ]);
    }

    /**
     * Create Razorpay order and payment record
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'building_id' => 'required|exists:buildings,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $building = Building::findOrFail($request->building_id);

        // Verify building belongs to authenticated user (for building admins) or user is Admin
        $user = Auth::user();
        if ($user->role_id !== 1 && $building->building_admin_id !== $user->id) {
            return response()->json(['success' => false, 'error' => 'Unauthorized access to this building'], 403);
        }

        // Calculate amount
        $units = $plan->billing_type === 'per_flat' ? ($building->flats()->count() ?? 1) : 1;
        $amount = $plan->price * $units;

        // Generate unique receipt ID
        $receiptId = 'BMP-' . $building->id . '-' . Str::random(8);

        // Create Razorpay order
        $orderResponse = $this->razorpay->createOrder(
            $amount,
            $receiptId,
            [
                'plan_id' => $plan->id,
                'building_id' => $building->id,
                'building_name' => $building->name,
            ]
        );

        if (!$orderResponse['success']) {
            return back()->with('error', 'Failed to create payment order: ' . $orderResponse['error']);
        }

        // Create payment record
        $payment = Payment::create([
            'building_id' => $building->id,
            'user_id' => Auth::id(),
            'gateway' => 'razorpay',
            'amount' => $amount,
            'status' => 'pending',
            'meta' => json_encode([
                'plan_id' => $plan->id,
                'units' => $units,
                'razorpay_order_id' => $orderResponse['order_id'],
                'receipt_id' => $receiptId,
            ]),
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $orderResponse['order_id'],
            'amount' => $orderResponse['amount'],
            'payment_id' => $payment->id,
        ]);
    }

    /**
     * Handle successful payment from Razorpay
     */
    public function handleSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;
        $signature = $request->razorpay_signature;

        // Verify signature
        if (!$this->razorpay->verifySignature($paymentId, $orderId, $signature)) {
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 401);
        }

        // Get payment details
        $paymentDetails = $this->razorpay->getPayment($paymentId);

        if (!$paymentDetails['success']) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch payment details'], 400);
        }

        // Find our payment record by order ID
        $payment = Payment::where('meta->razorpay_order_id', $orderId)
            ->orWhere('gateway_payment_id', $paymentId)
            ->first();

        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment record not found'], 404);
        }

        // Update payment status
        $payment->update([
            'status' => 'success',
            'gateway_payment_id' => $paymentId,
            'meta' => json_encode(array_merge(
                (array) json_decode($payment->meta, true),
                $paymentDetails
            )),
        ]);

        // Create subscription
        $this->createSubscriptionFromPayment($payment);

        return response()->json([
            'success' => true,
            'message' => 'Payment successful!',
            'redirect' => '/building-admin/dashboard',
        ]);
    }

    /**
     * Handle payment failure
     */
    public function handleFailure(Request $request)
    {
        $request->validate([
            'error_code' => 'required|string',
            'error_description' => 'required|string',
            'razorpay_payment_id' => 'nullable|string',
        ]);

        // Find and update payment record
        if ($request->razorpay_payment_id) {
            $payment = Payment::where('gateway_payment_id', $request->razorpay_payment_id)->first();

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'meta' => json_encode(array_merge(
                        (array) json_decode($payment->meta, true),
                        [
                            'error_code' => $request->error_code,
                            'error_description' => $request->error_description,
                        ]
                    )),
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => $request->error_description,
        ]);
    }

    /**
     * Webhook handler for Razorpay events
     */
    public function webhook(Request $request)
    {
        $event = $request->input('event');
        $data = $request->input('payload.payment.entity');

        // Verify webhook signature
        $webhookSecret = config('razorpay.webhook_secret');
        $signature = $request->header('X-Razorpay-Signature');
        $body = file_get_contents('php://input');

        if ($webhookSecret && $signature) {
            $expectedSignature = hash_hmac('sha256', $body, $webhookSecret, false);
            if ($signature !== $expectedSignature) {
                return response()->json(['error' => 'Invalid signature'], 401);
            }
        }

        if ($event === 'payment.authorized') {
            $this->handleAuthorizedPayment($data);
        } elseif ($event === 'payment.failed') {
            $this->handleFailedPayment($data);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle authorized payment webhook
     */
    protected function handleAuthorizedPayment(array $data): void
    {
        $payment = Payment::where('gateway_payment_id', $data['id'])->first();

        if (!$payment) {
            return;
        }

        $payment->update([
            'status' => 'success',
            'meta' => json_encode(array_merge(
                (array) json_decode($payment->meta, true),
                $data
            )),
        ]);

        $this->createSubscriptionFromPayment($payment);
    }

    /**
     * Handle failed payment webhook
     */
    protected function handleFailedPayment(array $data): void
    {
        $payment = Payment::where('gateway_payment_id', $data['id'])->first();

        if (!$payment) {
            return;
        }

        $payment->update([
            'status' => 'failed',
            'meta' => json_encode(array_merge(
                (array) json_decode($payment->meta, true),
                [
                    'error_code' => $data['error_code'] ?? null,
                    'error_description' => $data['error_description'] ?? null,
                ]
            )),
        ]);
    }

    /**
     * Create subscription from successful payment
     */
    protected function createSubscriptionFromPayment(Payment $payment): void
    {
        $meta = (array) json_decode($payment->meta, true);
        $planId = $meta['plan_id'] ?? null;

        if (!$planId) {
            return;
        }

        $plan = Plan::findOrFail($planId);
        $building = $payment->building;

        // Expire previous subscriptions
        Subscription::where('building_id', $building->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // Calculate subscription period
        $start = Carbon::today();
        $end = $plan->billing_cycle === 'yearly' ? $start->copy()->addYear() : $start->copy()->addMonth();

        // Create new subscription
        $subscription = Subscription::create([
            'building_id' => $building->id,
            'plan_id' => $plan->id,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'active',
            'price_per_unit' => $plan->price,
            'units' => $meta['units'] ?? 1,
            'total_amount' => $payment->amount,
        ]);

        // Update payment subscription reference
        $payment->update(['subscription_id' => $subscription->id]);

        // Mark building and admin as active
        $building->update(['status' => 'active']);
        if ($building->building_admin_id) {
            $building->admin->update(['status' => 'active']);
        }
    }

    /**
     * Simulate successful payment (for testing)
     */
    public function simulateSuccess(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        // Simulate successful payment
        $payment->update([
            'status' => 'success',
            'gateway_payment_id' => 'SIMULATED_' . Str::random(16),
        ]);

        // Create subscription
        $this->createSubscriptionFromPayment($payment);

        return redirect('/building-admin/dashboard')->with('success', 'Payment simulation successful!');
    }

    /**
     * View payment history
     */
    public function history()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with('building', 'subscription')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payments.history', compact('payments'));
    }

    /**
     * View single payment details
     */
    public function show(Payment $payment)
    {
        // Check authorization
        if ($payment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('payments.show', compact('payment'));
    }
}

