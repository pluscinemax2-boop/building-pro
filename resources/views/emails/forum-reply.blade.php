<x-mail::message>
# New Reply to: {{ $forumPost->title }}

Someone has replied to your forum discussion.

<x-mail::panel>
**Reply Details**

- **Thread:** {{ $forumPost->title }}
- **Replied By:** {{ $reply->author->name ?? 'Community Member' }}
- **Date:** {{ $reply->created_at->format('M d, Y H:i A') }}
</x-mail::panel>

## Reply Preview

{{ Str::limit(strip_tags($reply->content), 300) }}

<x-mail::button :url="route('forum.posts.show', $forumPost) . '#reply-' . $reply->id">
Read Full Reply
</x-mail::button>

Join the discussion and share your thoughts with your community!

Best regards,<br>
Building Manager Pro Community Team
</x-mail::message>
