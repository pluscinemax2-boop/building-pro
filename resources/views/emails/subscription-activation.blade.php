<x-mail::message>
# Your Subscription is Active! 🎉

Congratulations! Your subscription to Building Manager Pro has been successfully activated.

<x-mail::panel>
**Subscription Details**

- **Plan:** {{ $plan->name }}
- **Building:** {{ $building->name }}
- **Price:** ₹{{ number_format($plan->price / 100, 2) }}/{{ $plan->billing_cycle }}
- **Status:** Active
- **Features:** All premium features unlocked
</x-mail::panel>

## What's Included

Your building now has access to:
- 📧 Email notifications
- 📱 SMS alerts
- 📄 PDF reports
- 📊 Analytics dashboard
- 👥 User role management
- 🏠 Property management
- 🔧 Maintenance tracking
- 📢 Notice board
- 📁 Document storage
- 💰 Expense tracking
- 💳 Budget management
- 🗳️ Voting system
- 💬 Community forum

<x-mail::button :url="route('building-admin.dashboard')">
Access Your Dashboard
</x-mail::button>

If you have any questions or need assistance, our support team is here to help.

Best regards,<br>
Building Manager Pro Team
</x-mail::message>
