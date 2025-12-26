<x-mail::message>
# Weekly Digest - {{ $period }}

Hello {{ $user->name }},

Here's a summary of activity from this week:

<x-mail::panel>
**Weekly Activity Summary**

@if($payments->count() > 0)
📧 **{{ $payments->count() }} Payment(s)**
- Total: ₹{{ number_format($payments->sum('amount') / 100, 2) }}
- Last payment: {{ $payments->latest()->first()->created_at->format('M d, Y') }}
@endif

</x-mail::panel>

## Your Buildings

@foreach($user->buildings ?? [] as $building)
**{{ $building->name }}**
- Subscription: Active
- Status: Good Standing
@endforeach

## Quick Actions

<x-mail::button :url="route('building-admin.dashboard')">
View Dashboard
</x-mail::button>

---

**Preferences:** You're receiving this because you have weekly digests enabled. [Update preferences](/settings/notifications)

Best regards,<br>
Building Manager Pro
</x-mail::message>
