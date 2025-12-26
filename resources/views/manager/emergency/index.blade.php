<h2>Emergency Alerts (Manager View)</h2>

@foreach($alerts as $a)
    <div style="border:1px solid red; padding:10px; margin:10px;">
        <h3>{{ $a->title }} ({{ $a->type }})</h3>
        <p>{{ $a->message }}</p>
        <small>{{ $a->created_at }}</small>
    </div>
@endforeach

<br>
<a href="{{ url('/manager') }}">⬅ Back to Dashboard</a>
