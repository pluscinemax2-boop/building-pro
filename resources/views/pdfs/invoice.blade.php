<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 20px; }
        .row { margin-bottom: 8px; }
        .label { font-weight: bold; width: 160px; display: inline-block; }
        .value { display: inline-block; }
        .total { font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">Invoice - {{ $invoice->invoice_number }}</div>
    <div class="row"><span class="label">Invoice Date:</span> <span class="value">{{ $invoice->issue_date->format('d M Y') }}</span></div>
    <div class="row"><span class="label">Building Name:</span> <span class="value">{{ $invoice->building->name ?? '-' }}</span></div>
    <div class="row"><span class="label">Plan Name:</span> <span class="value">{{ $invoice->subscription->plan->name ?? '-' }}</span></div>
    <div class="row"><span class="label">Amount:</span> <span class="value">₹{{ $invoice->amount }}</span></div>
    <div class="row"><span class="label">Tax (GST):</span> <span class="value">₹{{ $invoice->meta['gst'] ?? '0.00' }}</span></div>
    <div class="row total"><span class="label">Total Amount:</span> <span class="value">₹{{ number_format($invoice->amount + ($invoice->meta['gst'] ?? 0), 2) }}</span></div>
    <div class="row"><span class="label">Payment Transaction ID:</span> <span class="value">{{ $invoice->meta['payment_transaction_id'] ?? '-' }}</span></div>
    <div class="row"><span class="label">Payment Date:</span> <span class="value">{{ $invoice->meta['payment_date'] ?? '-' }}</span></div>
    <div class="row"><span class="label">Status:</span> <span class="value">{{ ucfirst($invoice->status) }}</span></div>
</body>
</html>
