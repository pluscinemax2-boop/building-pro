@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Complaint Report Preview</h2>
    <iframe src="{{ route('complaint.report.download', ['from' => $from, 'to' => $to]) }}" width="100%" height="600" style="border:1px solid #ccc;"></iframe>
    <div class="mt-3">
        <a href="{{ route('complaint.report.download', ['from' => $from, 'to' => $to]) }}" class="btn btn-primary">Download PDF</a>
    </div>
</div>
@endsection
