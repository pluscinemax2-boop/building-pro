
@extends('layouts.app')

@section('content')
<div class="relative flex h-full min-h-screen w-full flex-col max-w-md mx-auto bg-background-light dark:bg-background-dark group/design-root shadow-xl">
    <!-- TopAppBar -->
    <div class="sticky top-0 z-10 flex items-center bg-white dark:bg-[#1c2936] p-4 border-b border-[#e5e7eb] dark:border-[#2a3c4d]">
        <a href="{{ route('building-admin.subscription') }}" class="flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-white transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">Payment Checkout</h2>
    </div>
    <!-- Card Content -->
    <div class="flex-1 overflow-y-auto pb-24">
        <div class="p-4">
            <div class="relative flex flex-col gap-4 rounded-xl bg-white dark:bg-[#1c2936] p-5 shadow-sm border border-[#e5e7eb] dark:border-[#2a3c4d]">
                <!-- Building Info -->
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-primary text-2xl">apartment</span>
                    <div>
                        <div class="text-lg font-bold text-[#111418] dark:text-white">{{ $building->name }}</div>
                        <div class="text-xs text-[#617589] dark:text-gray-400 flex items-center gap-1"><span class="material-symbols-outlined text-base">location_on</span>{{ $building->address }}</div>
                        <div class="text-xs text-[#617589] dark:text-gray-400 flex items-center gap-1"><span class="material-symbols-outlined text-base">home</span>{{ $building->total_flats }} Flats</div>
                    </div>
                </div>
                <hr class="border-[#e5e7eb] dark:border-[#2a3c4d] my-1"/>
                <!-- Plan Details -->
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">diamond</span>
                        <span class="text-lg font-bold text-[#111418] dark:text-white">{{ $plan->name }}</span>
                    </div>
                    <span class="text-2xl font-bold text-[#111418] dark:text-white">₹{{ number_format($plan->price, 0) }}</span>
                </div>
                <div class="text-xs text-[#617589] dark:text-gray-400 mb-2">{{ $plan->description ?? 'Full-featured package' }}</div>
                <!-- Features List -->
                @if($plan->features)
                    <div class="flex flex-col gap-1 mb-2">
                        @foreach($plan->features as $feature)
                            <div class="flex items-center gap-2 text-[13px] text-[#3d4d5c] dark:text-[#cbd5e1]">
                                <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
                                {{ $feature }}
                            </div>
                        @endforeach
                    </div>
                @endif
                <hr class="border-[#e5e7eb] dark:border-[#2a3c4d] my-1"/>
                <!-- Order Summary -->
                <div class="flex flex-col gap-2 mb-2">
                    <div class="flex justify-between text-sm">
                        <span>Plan Price</span>
                        <span class="font-semibold">₹{{ number_format($plan->price, 0) }}</span>
                    </div>
                    @if($units > 1)
                    <div class="flex justify-between text-sm">
                        <span>Units (Flats)</span>
                        <span class="font-semibold">{{ $units }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span class="font-semibold">₹{{ number_format($plan->price * $units, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-base font-bold text-[#111418] dark:text-white">Total Amount</span>
                        <span class="text-2xl font-bold text-primary">₹{{ number_format($amount, 0) }}</span>
                    </div>
                    <div class="text-xs text-[#617589] dark:text-gray-400">Billing Cycle: {{ ucfirst($plan->billing_cycle) }}</div>
                </div>
                <!-- Payment Info -->
                <div class="flex items-center gap-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 text-xs text-blue-900 dark:text-blue-200 mb-2">
                    <span class="material-symbols-outlined text-base">shield</span>
                    Secure payment powered by Razorpay
                </div>
                <!-- Payment Button -->
                <button id="payButton" onclick="openRazorpayCheckout()" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-primary hover:bg-blue-600 transition-colors text-white text-base font-bold leading-normal tracking-[0.015em] shadow-lg shadow-blue-500/20 disabled:opacity-60 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined mr-2">lock</span>
                    <span id="payButtonText">Pay Now with Razorpay</span>
                    <span id="payButtonLoader" class="ml-2 hidden animate-spin material-symbols-outlined">progress_activity</span>
                </button>
                <a href="{{ route('building-admin.subscription') }}" class="block text-center text-[#617589] dark:text-gray-400 text-xs mt-4 hover:text-primary">← Back to Subscription</a>
                <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg text-xs text-[#617589] dark:text-gray-400 space-y-1">
                    <div class="flex items-center gap-1"><span class="material-symbols-outlined text-green-600 text-xs">check_circle</span>Secure SSL encrypted connection</div>
                    <div class="flex items-center gap-1"><span class="material-symbols-outlined text-green-600 text-xs">check_circle</span>Multiple payment methods available</div>
                    <div class="flex items-center gap-1"><span class="material-symbols-outlined text-green-600 text-xs">check_circle</span>Instant subscription activation</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
let razorpayOrder = null;
let paymentReady = false;
async function initializePayment() {
    const payButton = document.getElementById('payButton');
    const payButtonText = document.getElementById('payButtonText');
    const payButtonLoader = document.getElementById('payButtonLoader');
    payButton.disabled = true;
    payButtonLoader.classList.remove('hidden');
    payButtonText.textContent = 'Preparing...';
    try {
        const response = await fetch('/building-admin/subscription/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                plan_id: {{ $plan->id }},
                building_id: {{ $building->id }}
            })
        });
        const data = await response.json();
        if (data.success) {
            razorpayOrder = data;
            paymentReady = true;
            payButton.disabled = false;
            payButtonText.textContent = 'Pay Now with Razorpay';
            payButtonLoader.classList.add('hidden');
        } else {
            payButtonText.textContent = 'Error';
            payButtonLoader.classList.add('hidden');
            alert('Error creating order: ' + data.message);
        }
    } catch (error) {
        payButtonText.textContent = 'Error';
        payButtonLoader.classList.add('hidden');
        console.error('Error:', error);
        alert('Error initializing payment');
    }
}
function openRazorpayCheckout() {
    if (!razorpayOrder || !paymentReady) {
        alert('Please wait, order is being created...');
        return;
    }
    const payButton = document.getElementById('payButton');
    const payButtonText = document.getElementById('payButtonText');
    const payButtonLoader = document.getElementById('payButtonLoader');
    payButton.disabled = true;
    payButtonLoader.classList.remove('hidden');
    payButtonText.textContent = 'Opening Razorpay...';
    const options = {
        key: '{{ $razorpayKeyId }}',
        amount: {{ $amount * 100 }},
        currency: 'INR',
        name: 'Building Manager Pro',
        description: '{{ $plan->name }} - {{ $building->name }}',
        order_id: razorpayOrder.order_id,
        handler: function(response) { verifyPayment(response); },
        prefill: {
            name: '{{ Auth::user()->name }}',
            email: '{{ Auth::user()->email }}',
            contact: ''
        },
        theme: { color: '#2563eb' },
        modal: { ondismiss: function() {
            payButton.disabled = false;
            payButtonText.textContent = 'Pay Now with Razorpay';
            payButtonLoader.classList.add('hidden');
            console.log('Payment window closed');
        } }
    };
    const rzp = new Razorpay(options);
    rzp.on('payment.failed', function(response) {
        handlePaymentFailure(response.error);
        payButton.disabled = false;
        payButtonText.textContent = 'Pay Now with Razorpay';
        payButtonLoader.classList.add('hidden');
    });
    rzp.open();
}
async function verifyPayment(response) {
    try {
        const verifyResponse = await fetch('/building-admin/subscription/payment-success', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature
            })
        });
        const data = await verifyResponse.json();
        if (data.success) {
            showSuccessMessage('Payment successful! Activating your subscription...');
            setTimeout(() => { window.location.href = data.redirect || '/building-admin/dashboard'; }, 2000);
        } else {
            alert('Payment verification failed: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Payment verification error');
    }
}
async function handlePaymentFailure(error) {
    try {
        await fetch('/building-admin/subscription/payment-failure', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(error)
        });
    } catch (e) { console.error('Error logging failure:', e); }
    alert('Payment failed: ' + error.description);
}
function showSuccessMessage(message) {
    const alert = document.createElement('div');
    alert.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg';
    alert.innerHTML = '<span class="material-symbols-outlined mr-2">check_circle</span>' + message;
    document.body.appendChild(alert);
}
document.addEventListener('DOMContentLoaded', initializePayment);
</script>
