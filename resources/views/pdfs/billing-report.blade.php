<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Billing Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 15px;
        }
        
        .header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 3px;
        }
        
        .header p {
            color: #666;
            font-size: 10px;
        }
        
        .report-info {
            background: #f0f0f0;
            padding: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
        }
        
        .info-item {
            flex: 1;
        }
        
        .info-label {
            color: #999;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        .info-value {
            font-weight: bold;
            color: #333;
            margin-top: 3px;
        }
        
        .section-title {
            background: #f0f0f0;
            padding: 8px 12px;
            font-weight: bold;
            color: #333;
            border-left: 4px solid #007bff;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 11px;
        }
        
        .summary-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .stat-box {
            flex: 1;
            min-width: 120px;
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 12px;
            text-align: center;
            border-radius: 4px;
        }
        
        .stat-label {
            color: #999;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-top: 5px;
        }
        
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        
        .payments-table th {
            background: #007bff;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .payments-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .payments-table tr:hover {
            background: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            text-align: center;
            color: #999;
            font-size: 9px;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $building->name }}</h1>
            <p>{{ $building->address }}</p>
        </div>

        <!-- Report Title -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #007bff; font-size: 18px;">Monthly Billing Report</h2>
            <p style="color: #666;">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
        </div>

        <!-- Report Info -->
        <div class="report-info">
            <div class="info-item">
                <div class="info-label">Period</div>
                <div class="info-value">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F 1') }} - {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->endOfMonth()->format('F d, Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Generated</div>
                <div class="info-value">{{ now()->format('M d, Y H:i A') }}</div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="section-title">Summary</div>
        <div class="summary-stats">
            <div class="stat-box">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Payments</div>
                <div class="stat-value">{{ $totalPayments }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Successful</div>
                <div class="stat-value">{{ $successfulPayments }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Success Rate</div>
                <div class="stat-value">{{ $totalPayments > 0 ? round(($successfulPayments / $totalPayments) * 100) : 0 }}%</div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="section-title">Payment Details</div>
        <table class="payments-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Resident</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td class="text-right">${{ number_format($payment->amount, 2) }}</td>
                    <td>
                        <span class="status-badge status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>{{ substr($payment->transaction_id, 0, 12) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        No payments recorded for this period
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automatically generated report for {{ $building->name }}</p>
            <p style="margin-top: 5px;">{{ config('app.name') }} | Building Management System</p>
        </div>
    </div>
</body>
</html>
