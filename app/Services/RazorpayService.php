<?php

namespace App\Services;

use Razorpay\Api\Api;
use Exception;

class RazorpayService
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key_id'),
            config('razorpay.key_secret')
        );
    }

    /**
     * Create a Razorpay order
     *
     * @param float $amount Amount in paise (multiply by 100 from rupees)
     * @param string $receipt_id Unique receipt ID
     * @param array $notes Additional notes
     * @return array Order details
     */
    public function createOrder(float $amount, string $receipt_id, array $notes = []): array
    {
        try {
            $order = $this->api->order->create([
                'amount' => (int) ($amount * 100), // Convert to paise
                'currency' => 'INR',
                'receipt' => $receipt_id,
                'notes' => $notes,
            ]);

            return [
                'success' => true,
                'order_id' => $order->id,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'receipt' => $order->receipt,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment signature
     *
     * @param string $payment_id Razorpay payment ID
     * @param string $order_id Razorpay order ID
     * @param string $signature Razorpay signature
     * @return bool Is signature valid
     */
    public function verifySignature(string $payment_id, string $order_id, string $signature): bool
    {
        try {
            $attributes = [
                'order_id' => $order_id,
                'payment_id' => $payment_id,
                'signature' => $signature,
            ];

            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Fetch payment details from Razorpay
     *
     * @param string $payment_id Razorpay payment ID
     * @return array Payment details or error
     */
    public function getPayment(string $payment_id): array
    {
        try {
            $payment = $this->api->payment->fetch($payment_id);

            return [
                'success' => true,
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'status' => $payment->status,
                'method' => $payment->method,
                'email' => $payment->email,
                'contact' => $payment->contact,
                'description' => $payment->description,
                'notes' => $payment->notes,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund a payment
     *
     * @param string $payment_id Razorpay payment ID
     * @param int|null $amount Amount to refund (optional, full refund if null)
     * @param string|null $reason Refund reason
     * @return array Refund details or error
     */
    public function refundPayment(string $payment_id, ?int $amount = null, ?string $reason = null): array
    {
        try {
            $params = [];
            if ($amount) {
                $params['amount'] = $amount;
            }
            if ($reason) {
                $params['notes'] = ['reason' => $reason];
            }

            $refund = $this->api->payment->fetch($payment_id)->refund($params);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $refund->amount,
                'status' => $refund->status,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get Razorpay Key ID for frontend
     *
     * @return string
     */
    public function getKeyId(): string
    {
        return config('razorpay.key_id');
    }
}
