<x-mail::message>
# New Announcement: {{ $notice->title }}

A new announcement has been posted on your building's notice board.

<x-mail::panel>
**Announcement Details**

- **Building:** {{ $building->name }}
- **Posted By:** {{ $notice->postedBy->name ?? 'Building Management' }}
- **Date:** {{ $notice->created_at->format('M d, Y H:i A') }}
- **Priority:** {{ ucfirst($notice->priority ?? 'Normal') }}
</x-mail::panel>

## Message

{{ Str::limit($notice->content, 300) }}

<x-mail::button :url="route('building-admin.notices.show', $notice)">
Read Full Announcement
</x-mail::button>

@if($notice->expires_at)
**Expires:** {{ $notice->expires_at->format('M d, Y') }}
@endif

Stay informed about important building updates.

Best regards,<br>
Building Manager Pro Team
</x-mail::message>
