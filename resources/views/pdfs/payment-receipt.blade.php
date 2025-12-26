<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-info h1 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .company-info p {
            color: #666;
            font-size: 11px;
        }
        
        .receipt-title {
            text-align: right;
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
        }
        
        .receipt-number {
            text-align: right;
            color: #666;
            font-size: 11px;
            margin-top: 10px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #f0f0f0;
            padding: 8px 12px;
            font-weight: bold;
            color: #333;
            border-left: 4px solid #007bff;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .two-column {
            display: flex;
            gap: 40px;
        }
        
        .column {
            flex: 1;
        }
        
        .field-label {
            color: #999;
            font-size: 10px;
            text-transform: uppercase;
            margin-top: 10px;
        }
        
        .field-value {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .summary-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .summary-table td:first-child {
            width: 60%;
            color: #666;
        }
        
        .summary-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #333;
        }
        
        .total-row {
            background: #f0f0f0;
            border-top: 2px solid #007bff;
            border-bottom: 2px solid #007bff;
        }
        
        .total-row td:first-child {
            font-weight: bold;
            color: #007bff;
        }
        
        .total-row td:last-child {
            color: #007bff;
            font-size: 16px;
        }
        
        .payment-status {
            background: #d4edda;
            border: 1px solid #28a745;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
        }
        
        .payment-status.failed {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .footer {
            text-align: center;
            color: #999;
            font-size: 10px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .thank-you {
            text-align: center;
            color: #007bff;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ config('app.name') }}</h1>
                <p>Building Management Pro</p>
            </div>
            <div>
                <div class="receipt-title">PAYMENT RECEIPT</div>
                <div class="receipt-number">Receipt #: {{ $payment->id }}</div>
            </div>
        </div>

        <!-- Receipt Details -->
        <div class="section">
            <div class="section-title">Receipt Information</div>
            <div class="two-column">
                <div class="column">
                    <div class="field-label">Transaction ID</div>
                    <div class="field-value">{{ $payment->transaction_id }}</div>
                    
                    <div class="field-label">Date</div>
                    <div class="field-value">{{ $payment->created_at->format('M d, Y') }}</div>
                    
                    <div class="field-label">Payment Method</div>
                    <div class="field-value">{{ ucfirst($payment->payment_method) }}</div>
                </div>
                <div class="column">
                    <div class="field-label">Status</div>
                    <div class="field-value">{{ ucfirst($payment->status) }}</div>
                    
                    <div class="field-label">Period</div>
                    <div class="field-value">{{ $payment->period_start?->format('M d, Y') }} - {{ $payment->period_end?->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Payer Information -->
        <div class="section">
            <div class="section-title">Payer Information</div>
            <div class="two-column">
                <div class="column">
                    <div class="field-label">Name</div>
                    <div class="field-value">{{ $payment->user->name }}</div>
                    
                    <div class="field-label">Email</div>
                    <div class="field-value">{{ $payment->user->email }}</div>
                    
                    <div class="field-label">Phone</div>
                    <div class="field-value">{{ $payment->user->phone ?? 'N/A' }}</div>
                </div>
                <div class="column">
                    <div class="field-label">Building</div>
                    <div class="field-value">{{ $payment->building->name ?? 'N/A' }}</div>
                    
                    <div class="field-label">Address</div>
                    <div class="field-value">{{ $payment->building->address ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="section">
            <div class="section-title">Payment Summary</div>
            <table class="summary-table">
                <tr>
                    <td>Plan / Subscription</td>
                    <td>{{ $payment->subscription->plan->name ?? 'One-time Payment' }}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                </tr>
                @if($payment->discount_amount)
                <tr>
                    <td>Discount</td>
                    <td>-${{ number_format($payment->discount_amount, 2) }}</td>
                </tr>
                @endif
                @if($payment->tax_amount)
                <tr>
                    <td>Tax ({{ $payment->tax_percentage }}%)</td>
                    <td>${{ number_format($payment->tax_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total Amount</td>
                    <td>${{ number_format($payment->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Status -->
        <div class="payment-status {{ $payment->status === 'completed' ? '' : 'failed' }}">
            @if($payment->status === 'completed')
                ✓ Payment Successfully Received
            @else
                Payment {{ ucfirst($payment->status) }}
            @endif
        </div>

        <!-- Notes -->
        @if($payment->notes)
        <div class="section">
            <div class="section-title">Notes</div>
            <p>{{ $payment->notes }}</p>
        </div>
        @endif

        <!-- Thank You -->
        <div class="thank-you">
            Thank you for your payment!
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automatically generated receipt. Please keep this for your records.</p>
            <p>{{ config('app.name') }} | Generated on {{ now()->format('M d, Y \a\t H:i A') }}</p>
        </div>
    </div>
</body>
</html>
