<x-mail::message>
# Monthly Summary - {{ $period }}

Hello {{ $user->name }},

Here's your activity summary for {{ $period }}:

<x-mail::panel>
**Monthly Overview**

📊 **Total Activities:** {{ $totalActivity }}

- 💳 Payments: {{ $summary['payments'] }}
- 🚨 Complaints: {{ $summary['complaints'] }}
- 🔧 Maintenance: {{ $summary['maintenance'] }}
- 📢 Announcements: {{ $summary['announcements'] }}

</x-mail::panel>

## Building Performance

Your buildings continue to maintain good standing. All systems operational.

## Next Steps

Review detailed reports in your dashboard for deeper insights:

<x-mail::button :url="route('building-admin.dashboard')">
View Full Dashboard
</x-mail::button>

---

**Preferences:** You're receiving this because you have monthly digests enabled. [Update preferences](/settings/notifications)

Best regards,<br>
Building Manager Pro Team
</x-mail::message>
