<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForumReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $forumPost;
    public $reply;
    public $originalAuthor;

    /**
     * Create a new message instance.
     */
    public function __construct($forumPost, $reply, $originalAuthor)
    {
        $this->forumPost = $forumPost;
        $this->reply = $reply;
        $this->originalAuthor = $originalAuthor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Reply: ' . $this->forumPost->title,
            from: env('MAIL_FROM_ADDRESS', 'noreply@buildingmanager.local'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.forum-reply',
            with: [
                'forumPost' => $this->forumPost,
                'reply' => $this->reply,
                'originalAuthor' => $this->originalAuthor,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
