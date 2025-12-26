<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmergencyAlert;

class EmergencyAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public EmergencyAlert $alert;

    /**
     * Create a new message instance.
     */
    public function __construct(EmergencyAlert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ URGENT: Emergency Alert - ' . $this->alert->type,
            from: env('MAIL_FROM_ADDRESS', 'noreply@buildingmanager.local'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.emergency-alert',
            with: [
                'alert' => $this->alert,
                'alertType' => ucfirst(str_replace('_', ' ', $this->alert->type)),
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
