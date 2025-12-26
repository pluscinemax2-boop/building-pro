<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Complaint;

class ComplaintUpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Complaint $complaint;
    public string $updateType; // 'created', 'updated', 'resolved'

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint, string $updateType = 'created')
    {
        $this->complaint = $complaint;
        $this->updateType = $updateType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $typeLabel = match($this->updateType) {
            'created' => 'New Complaint',
            'updated' => 'Complaint Updated',
            'resolved' => 'Complaint Resolved',
            default => 'Complaint Update',
        };

        return new Envelope(
            subject: $typeLabel . ' - Complaint #' . $this->complaint->id,
            from: env('MAIL_FROM_ADDRESS', 'noreply@buildingmanager.local'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint-update',
            with: [
                'complaint' => $this->complaint,
                'updateType' => $this->updateType,
                'statusLabel' => ucfirst($this->complaint->status),
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
