<h2>Simulate Payment</h2>
<p>Payment ID: {{ $paymentId }}</p>

<form method="POST" action="{{ url('/admin/subscription/webhook/success') }}">
    @csrf
    <input type="hidden" name="payment_id" value="{{ $paymentId }}">
    <input type="hidden" name="gateway_payment_id" value="SIM_GW_{{ $paymentId }}">
    <button type="submit">Simulate Successful Payment</button>
</form>
