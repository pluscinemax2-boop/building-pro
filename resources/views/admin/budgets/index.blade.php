<h2>Budgets</h2>
<a href="{{ route('admin.budgets.create') }}">+ Add Budget</a>
<br><br>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Amount</th>
        <th>Start</th>
        <th>End</th>
        <th>Actual</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @foreach($budgets as $budget)
    <tr>
        <td>{{ $budget->title }}</td>
        <td>{{ $budget->category ? $budget->category->name : '-' }}</td>
        <td>{{ number_format($budget->amount, 2) }}</td>
        <td>{{ $budget->start_date }}</td>
        <td>{{ $budget->end_date }}</td>
        <td>{{ number_format($budget->actualExpenses(), 2) }}</td>
        <td>
            @if($budget->isExceeded())
                <span style="color:red;">Exceeded</span>
            @else
                <span style="color:green;">OK</span>
            @endif
        </td>
        <td></td>
    </tr>
    @endforeach
</table>
