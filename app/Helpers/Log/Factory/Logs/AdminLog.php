<?php

namespace App\Helpers\Log\Factory\Logs;

use App\Events\AdminLogEvent;
use App\Helpers\Log\Factory\Logs\model\BasicLog;
use App\Models\Entities\CmsLog;
use App\Models\Entities\DBLogInterface;

class AdminLog extends AbstractLog implements LogInterface
{
    /**
     * 設定隊列事件
     *
     * @param DBLogInterface|CmsLog $model
     *
     * @return mixed|void
     */
    public function onQueue(DBLogInterface $model)
    {
        event(new AdminLogEvent($model));
    }

    /**
     * 轉換log資料格式
     *
     * @return CmsLog
     */
    protected function convertBasicLog(BasicLog $log)
    {
        $cmsLog = new CmsLog();
        $cmsLog->admin_id = $log->user->id;
        $cmsLog->level = $log->level;
        $cmsLog->description = $log->description;
        $cmsLog->json_info = (!empty($log->json_info)) ? $log->json_info : null;
        $cmsLog->class_path = $log->class_path;

        $now = date('Y-m-d H:i:s');
        $cmsLog->updated_at = $now;
        $cmsLog->created_at = $now;

        return $cmsLog;
    }
}
