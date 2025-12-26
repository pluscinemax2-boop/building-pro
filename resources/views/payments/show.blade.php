<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details - Building Manager Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="/admin/payments" class="text-purple-600 hover:text-purple-900 font-semibold mb-4 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Payments
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
            </div>

            @php
                $meta = json_decode($payment->meta, true);
            @endphp

            <!-- Status Banner -->
            <div class="mb-8 p-6 rounded-xl {{ $payment->status === 'success' ? 'bg-green-50 border-l-4 border-green-600' : ($payment->status === 'pending' ? 'bg-yellow-50 border-l-4 border-yellow-600' : 'bg-red-50 border-l-4 border-red-600') }}">
                <div class="flex items-center space-x-3">
                    <div class="text-3xl">
                        @if($payment->status === 'success')
                            <i class="fas fa-check-circle text-green-600"></i>
                        @elseif($payment->status === 'pending')
                            <i class="fas fa-hourglass-half text-yellow-600"></i>
                        @else
                            <i class="fas fa-times-circle text-red-600"></i>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold {{ $payment->status === 'success' ? 'text-green-900' : ($payment->status === 'pending' ? 'text-yellow-900' : 'text-red-900') }}">
                            Payment {{ ucfirst($payment->status) }}
                        </h2>
                        <p class="{{ $payment->status === 'success' ? 'text-green-700' : ($payment->status === 'pending' ? 'text-yellow-700' : 'text-red-700') }}">
                            @if($payment->status === 'success')
                                Your payment has been processed successfully
                            @elseif($payment->status === 'pending')
                                Your payment is still being processed
                            @else
                                Your payment could not be processed
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Payment Information -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Payment Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Payment ID</p>
                                <p class="font-mono text-sm text-gray-900">{{ $payment->id }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-1">Gateway Payment ID</p>
                                <p class="font-mono text-sm text-gray-900">{{ $payment->gateway_payment_id ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-1">Payment Gateway</p>
                                <p class="text-sm text-gray-900 font-semibold">{{ ucfirst($payment->gateway) }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-1">Payment Date</p>
                                <p class="text-sm text-gray-900">{{ $payment->created_at->format('d M Y, H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Building & Plan Information -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Subscription Details</h3>

                        <!-- Building -->
                        <div class="mb-6 pb-6 border-b">
                            <p class="text-sm text-gray-600 mb-3">Building</p>
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-building text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $payment->building->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $payment->building->address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Plan -->
                        @if($payment->subscription)
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Selected Plan</p>
                            <div class="bg-gradient-to-br from-purple-600 to-pink-600 text-white rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $payment->subscription->plan->name }}</h4>
                                        <p class="text-sm text-purple-100">Active until {{ $payment->subscription->end_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-2xl font-bold">₹{{ number_format($payment->subscription->plan->price, 0) }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Transaction Details -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Transaction Details</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between pb-4 border-b">
                                <span class="text-gray-700">Amount Paid</span>
                                <span class="font-bold text-lg text-gray-900">₹{{ number_format($payment->amount, 0) }}</span>
                            </div>

                            <div class="flex justify-between pb-4 border-b">
                                <span class="text-gray-700">Payment Status</span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $payment->status === 'success' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>

                            <div class="flex justify-between pb-4 border-b">
                                <span class="text-gray-700">Payment Method</span>
                                <span class="text-gray-900">
                                    @if(isset($meta['method']))
                                        <i class="fas fa-credit-card mr-2"></i>{{ ucfirst(str_replace('_', ' ', $meta['method'])) }}
                                    @else
                                        —
                                    @endif
                                </span>
                            </div>

                            @if(isset($meta['email']))
                            <div class="flex justify-between">
                                <span class="text-gray-700">Payer Email</span>
                                <span class="text-gray-900">{{ $meta['email'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Summary -->
                <div>
                    <div class="bg-white rounded-xl shadow-lg p-8 sticky top-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Summary</h3>

                        <div class="space-y-4 pb-6 border-b">
                            <div>
                                <p class="text-sm text-gray-600">Reference ID</p>
                                <p class="font-mono text-xs text-gray-700 mt-1 break-all">{{ $payment->id }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Transaction Date</p>
                                <p class="text-sm text-gray-900 font-semibold mt-1">
                                    {{ $payment->created_at->format('d M Y') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Transaction Time</p>
                                <p class="text-sm text-gray-900 font-semibold mt-1">
                                    {{ $payment->created_at->format('H:i:s') }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Amount Paid</p>
                            <p class="text-3xl font-bold gradient-primary bg-clip-text text-transparent">
                                ₹{{ number_format($payment->amount, 0) }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <button onclick="printReceipt()" class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition flex items-center justify-center space-x-2">
                                <i class="fas fa-print"></i>
                                <span>Print Receipt</span>
                            </button>

                            <a href="/admin/payments" class="block text-center px-4 py-2 bg-gray-100 text-gray-900 rounded-lg hover:bg-gray-200 transition">
                                Back to List
                            </a>
                        </div>

                        <!-- Info Box -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <p class="text-xs text-blue-900">
                                <i class="fas fa-info-circle mr-2"></i>
                                Keep this payment reference for your records
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</body>
</html>
