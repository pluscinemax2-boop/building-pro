<x-mail::message>
# ⚠️ EMERGENCY ALERT

A critical emergency alert has been issued for your building.

<x-mail::panel>
**ALERT TYPE:** {{ $alertType }}

**Severity:** URGENT
**Building:** {{ $alert->building->name ?? 'Your Building' }}
**Time:** {{ $alert->created_at->format('M d, Y H:i A') }}
</x-mail::panel>

## Alert Description

{{ $alert->description }}

**Issued By:** {{ $alert->issuedBy->name ?? 'Building Management' }}

## Required Action

Please follow the instructions provided by building management immediately. 

@if($alert->action_required)
**Action Required:** Yes

Check your building management app for specific instructions or contact building management immediately.
@endif

<x-mail::button :url="route('building-admin.alerts.show', $alert)" color="error">
View Full Alert
</x-mail::button>

**Stay Safe!**

Best regards,<br>
Building Manager Pro - Emergency Alert System
</x-mail::message>
