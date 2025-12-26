@extends('building-admin.layout')

@section('content')
<div style="font-family: 'Inter', sans-serif; color: #222; max-width: 600px; margin: 0 auto;">
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Expense Details</h2>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="font-weight: bold;">Title:</td>
            <td>{{ $expense->title }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Category:</td>
            <td>{{ $expense->category->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Vendor:</td>
            <td>{{ $expense->vendor ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Amount:</td>
            <td>₹{{ number_format($expense->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Expense Date:</td>
            <td>{{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Description:</td>
            <td>{{ $expense->description ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Status:</td>
            <td>Approved</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Approved At:</td>
            <td>{{ $expense->approved_at ? \Illuminate\Support\Carbon::parse($expense->approved_at)->format('M d, Y h:i A') : '-' }}</td>
        </tr>
        @if($expense->file)
        <tr>
            <td style="font-weight: bold;">Bill Attachment:</td>
            <td>
                @if(Str::startsWith($expense->file->file_type, 'image/'))
                    <img src="{{ public_path('storage/' . $expense->file->file_path) }}" alt="Bill Image" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #eee;">
                @else
                    <span>{{ $expense->file->original_name }}</span>
                @endif
            </td>
        </tr>
        @endif
    </table>
</div>
@endsection