<x-mail::message>
# Complaint Status Update

Your complaint has been {{ $updateType === 'created' ? 'received' : $updateType }}.

<x-mail::panel>
**Complaint Details**

- **Complaint ID:** {{ $complaint->id }}
- **Category:** {{ ucfirst($complaint->category) }}
- **Current Status:** {{ $statusLabel }}
- **Reported Date:** {{ $complaint->created_at->format('M d, Y') }}
- **Building:** {{ $complaint->resident->building->name ?? 'N/A' }}
</x-mail::panel>

## Description

{{ $complaint->description }}

## Next Steps

Your complaint has been logged in our system. You will receive updates via email as the status changes. 

@if($updateType === 'resolved')
<x-mail::button :url="route('resident.complaints.show', $complaint)">
View Complaint Details
</x-mail::button>
@endif

Thank you for helping us maintain our community standards.

Best regards,<br>
Building Manager Pro Team
</x-mail::message>
