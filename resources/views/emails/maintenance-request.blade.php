<x-mail::message>
# Maintenance Request Status

Your maintenance request has been {{ $updateType === 'created' ? 'created' : $updateType }}.

<x-mail::panel>
**Request Details**

- **Request ID:** {{ $maintenanceRequest->id }}
- **Type:** {{ ucfirst($maintenanceRequest->type ?? 'General') }}
- **Status:** {{ ucfirst($maintenanceRequest->status ?? 'Pending') }}
- **Requested Date:** {{ $maintenanceRequest->created_at->format('M d, Y') }}
</x-mail::panel>

## Description

{{ $maintenanceRequest->description ?? 'No description provided' }}

@if($updateType === 'assigned')
**Assigned To:** {{ $maintenanceRequest->assignedTo->name ?? 'Pending Assignment' }}
@elseif($updateType === 'completed')
**Completed Date:** {{ $maintenanceRequest->completed_at?->format('M d, Y') ?? 'Not yet completed' }}
@endif

<x-mail::button :url="route('building-admin.maintenance.show', $maintenanceRequest)">
View Details
</x-mail::button>

Thank you for maintaining our community.

Best regards,<br>
Building Manager Pro Team
</x-mail::message>
