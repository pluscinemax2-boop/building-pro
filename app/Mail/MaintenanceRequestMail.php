<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $maintenanceRequest;
    public string $updateType; // 'created', 'assigned', 'completed'

    /**
     * Create a new message instance.
     */
    public function __construct($maintenanceRequest, string $updateType = 'created')
    {
        $this->maintenanceRequest = $maintenanceRequest;
        $this->updateType = $updateType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $typeLabel = match($this->updateType) {
            'created' => 'New Maintenance Request',
            'assigned' => 'Maintenance Request Assigned',
            'completed' => 'Maintenance Completed',
            default => 'Maintenance Update',
        };

        return new Envelope(
            subject: $typeLabel . ' - Request #' . $this->maintenanceRequest->id,
            from: env('MAIL_FROM_ADDRESS', 'noreply@buildingmanager.local'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.maintenance-request',
            with: [
                'maintenanceRequest' => $this->maintenanceRequest,
                'updateType' => $this->updateType,
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
