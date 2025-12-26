<h2>Expenses</h2>
<a href="{{ route('admin.expenses.create') }}">+ Add Expense</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Date</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Approved By</th>
        <th>Action</th>
    </tr>
    @foreach($expenses as $expense)
    <tr>
        <td>{{ $expense->title }}</td>
        <td>{{ number_format($expense->amount, 2) }}</td>
        <td>{{ $expense->category ? $expense->category->name : '-' }}</td>
        <td>{{ $expense->expense_date }}</td>
        <td>{{ ucfirst($expense->status) }}</td>
        <td>{{ $expense->creator ? $expense->creator->name : '-' }}</td>
        <td>{{ $expense->approver ? $expense->approver->name : '-' }}</td>
        <td>
            @if($expense->status == 'pending')
            <form action="{{ route('admin.expenses.approve', $expense->id) }}" method="POST" style="display:inline;">
                @csrf
                <button name="status" value="approved">Approve</button>
                <button name="status" value="rejected">Reject</button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>
