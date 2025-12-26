<?php

namespace App\Events;

use App\Models\Complaint;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComplaintUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Complaint $complaint;
    public string $updateType; // created, updated, resolved

    /**
     * Create a new event instance.
     */
    public function __construct(Complaint $complaint, string $updateType = 'updated')
    {
        $this->complaint = $complaint;
        $this->updateType = $updateType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('complaint.' . $this->complaint->id),
        ];
    }
}
