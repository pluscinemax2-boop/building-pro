<h2>Manager Dashboard</h2>

<ul>
    <li>Total Flats: {{ $totalFlats }}</li>
    <li>Total Residents: {{ $totalResidents }}</li>
    <li>Open Complaints: {{ $openComplaints }}</li>
    <li>In Progress Complaints: {{ $inProgress }}</li>
</ul>

<a href="{{ url('/manager/complaints') }}">View All Complaints</a> |
<a href="{{ url('/manager/emergency') }}">View Emergency Alerts</a>
