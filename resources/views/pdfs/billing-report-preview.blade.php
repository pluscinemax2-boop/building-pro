@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Billing Report Preview</h2>
    <iframe src="{{ route('billing.report.download', ['month' => $month, 'year' => $year]) }}" width="100%" height="600" style="border:1px solid #ccc;"></iframe>
    <div class="mt-3">
        <a href="{{ route('billing.report.download', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">Download PDF</a>
    </div>
</div>
@endsection
