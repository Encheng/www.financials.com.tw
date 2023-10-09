<?php

namespace App\Events;

use App\Models\Entities\CmsLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminLogEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $log;

    /**
     * Create a new event instance.
     *
     * @param CmsLog $cmsLog
     */
    public function __construct(CmsLog $cmsLog)
    {
        $this->log = $cmsLog->toArray();
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
