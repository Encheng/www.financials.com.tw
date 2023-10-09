<?php

namespace App\Events;

use App\Models\Entities\Admin;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminUpdatedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $adminId;

    /**
     * Create a new event instance.
     *
     * @param Admin|int $admin
     */
    public function __construct($admin)
    {
        $this->adminId = ($admin instanceof Admin) ? $admin->id : $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
