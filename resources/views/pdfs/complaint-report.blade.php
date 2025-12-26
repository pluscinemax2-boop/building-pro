<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Complaint Report</title>
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
            border-bottom: 3px solid #dc3545;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            color: #dc3545;
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
            border-left: 4px solid #dc3545;
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
            border-left: 4px solid #dc3545;
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
            color: #dc3545;
            margin-top: 5px;
        }
        
        .complaints-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        
        .complaints-table th {
            background: #dc3545;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .complaints-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .complaints-table tr:hover {
            background: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .status-open {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-in_progress {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-resolved {
            background: #d4edda;
            color: #155724;
        }
        
        .status-closed {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .category-breakdown {
            display: flex;
            gap: 15px;
            margin: 15px 0;
            flex-wrap: wrap;
        }
        
        .category-item {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #dc3545;
        }
        
        .category-name {
            font-weight: bold;
            color: #333;
        }
        
        .category-count {
            color: #999;
            font-size: 9px;
            margin-top: 2px;
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
            <h2 style="color: #dc3545; font-size: 18px;">Complaint Report</h2>
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
                <div class="stat-label">Total Complaints</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Open</div>
                <div class="stat-value">{{ $stats['open'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">In Progress</div>
                <div class="stat-value">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Resolved</div>
                <div class="stat-value">{{ $stats['resolved'] }}</div>
            </div>
        </div>

        <!-- Category Breakdown -->
        @if($byCategory->count() > 0)
        <div class="section-title">By Category</div>
        <div class="category-breakdown">
            @foreach($byCategory as $category => $count)
            <div class="category-item">
                <div class="category-name">{{ ucfirst($category) }}</div>
                <div class="category-count">{{ $count }} complaint{{ $count !== 1 ? 's' : '' }}</div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Complaints Table -->
        <div class="section-title">Complaint Details</div>
        <table class="complaints-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Resident</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                <tr>
                    <td>#{{ $complaint->id }}</td>
                    <td>{{ $complaint->user->name }}</td>
                    <td>{{ ucfirst($complaint->category) }}</td>
                    <td>
                        <span class="status-badge status-{{ $complaint->status }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </td>
                    <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #999;">
                        No complaints recorded for this period
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
