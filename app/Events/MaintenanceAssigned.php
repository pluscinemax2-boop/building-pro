<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaintenanceAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $maintenanceRequest;
    public string $updateType; // created, assigned, completed

    /**
     * Create a new event instance.
     */
    public function __construct($maintenanceRequest, string $updateType = 'assigned')
    {
        $this->maintenanceRequest = $maintenanceRequest;
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
            new PrivateChannel('maintenance.' . $this->maintenanceRequest->id),
        ];
    }
}
