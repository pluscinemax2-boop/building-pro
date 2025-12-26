<h2>Choose a Plan for {{ $building->name }}</h2>

@if(session('success')) <p>{{ session('success') }}</p> @endif

@foreach($plans as $plan)
 <div style="border:1px solid #ccc;padding:10px;margin:10px;">
    <h3>{{ $plan->name }} — {{ $plan->price }}</h3>
    <p>{{ $plan->description }}</p>
    <form method="POST" action="{{ url('/admin/subscription/checkout') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <input type="hidden" name="building_id" value="{{ $building->id }}">
        <button type="submit">Select & Pay</button>
    </form>
 </div>
@endforeach
