<h2>Send Emergency Alert</h2>

<form method="POST" action="{{ url('/admin/emergency') }}">
@csrf

<input type="text" name="title" placeholder="Title" required><br><br>
<textarea name="message" placeholder="Message" required></textarea><br><br>

<select name="type">
<option>Fire</option>
<option>Gas</option>
<option>Power</option>
<option>Water</option>
<option>Security</option>
</select><br><br>

<button type="submit">Send Alert</button>
</form>
