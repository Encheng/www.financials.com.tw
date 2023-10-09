<?php

namespace App\Listeners;

use App\Events\AdminLogEvent;
use App\Models\Entities\CmsLog;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminLogWrite implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(AdminLogEvent $event)
    {
        try {
            $model = new CmsLog();
            $model->fill($event->log);
            $model->save();
        } catch (Exception $exception) {
            $info = [__METHOD__, 'cms_logs write fail'];
            \Log::error($exception->getMessage(), $info);
        }
    }
}
