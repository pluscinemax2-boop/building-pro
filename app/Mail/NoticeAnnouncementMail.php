<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoticeAnnouncementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $notice;
    public $building;

    /**
     * Create a new message instance.
     */
    public function __construct($notice, $building)
    {
        $this->notice = $notice;
        $this->building = $building;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Announcement: ' . $this->notice->title,
            from: env('MAIL_FROM_ADDRESS', 'noreply@buildingmanager.local'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notice-announcement',
            with: [
                'notice' => $this->notice,
                'building' => $this->building,
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
