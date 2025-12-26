@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Payment Receipt Preview</h2>
    <iframe src="{{ route('payment.receipt.download', $payment) }}" width="100%" height="600" style="border:1px solid #ccc;"></iframe>
    <div class="mt-3">
        <a href="{{ route('payment.receipt.download', $payment) }}" class="btn btn-primary">Download PDF</a>
    </div>
</div>
@endsection
