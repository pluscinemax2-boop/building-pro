<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Building Manager Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center space-x-3">
                            <i class="fas fa-history gradient-primary bg-clip-text text-transparent text-4xl"></i>
                            <span>Payment History</span>
                        </h1>
                        <p class="text-gray-600 mt-2">View all your subscription and payment records</p>
                    </div>
                    <a href="/admin/dashboard" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Payments Table -->
            @if($payments->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Building</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Plan</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Amount</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Gateway</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            @php
                                $meta = json_decode($payment->meta, true);
                                $plan = $payment->subscription?->plan ?? null;
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-building text-blue-600"></i>
                                        <span class="font-medium text-gray-900">{{ $payment->building->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($plan)
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                            {{ $plan->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="font-bold text-gray-900">₹{{ number_format($payment->amount, 0) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                        {{ ucfirst($payment->gateway) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($payment->status === 'success')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i>Success
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-hourglass-half mr-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i>Failed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="/admin/payments/{{ $payment->id }}" class="text-purple-600 hover:text-purple-900 font-semibold">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4 p-4">
                    @foreach($payments as $payment)
                    @php
                        $meta = json_decode($payment->meta, true);
                        $plan = $payment->subscription?->plan ?? null;
                    @endphp
                    <div class="bg-white border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $payment->building->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            @if($payment->status === 'success')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">Success</span>
                            @elseif($payment->status === 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">Pending</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-bold">Failed</span>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm mb-4 pb-4 border-b">
                            @if($plan)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Plan:</span>
                                <span class="font-semibold text-gray-900">{{ $plan->name }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-bold text-gray-900">₹{{ number_format($payment->amount, 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gateway:</span>
                                <span class="font-semibold text-gray-900">{{ ucfirst($payment->gateway) }}</span>
                            </div>
                        </div>

                        <a href="/admin/payments/{{ $payment->id }}" class="text-purple-600 hover:text-purple-900 font-semibold text-sm">
                            View Details →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $payments->links() }}
            </div>

            @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No Payments Yet</h3>
                <p class="text-gray-600 mb-6">You haven't made any payments yet. Start by activating a plan.</p>
                <a href="/building-admin/subscription" class="px-6 py-2 gradient-primary text-white rounded-lg hover:opacity-90">
                    <i class="fas fa-plus mr-2"></i>Activate Plan
                </a>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
