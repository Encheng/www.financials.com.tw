<?php

namespace App\Helpers\Log\Factory\Logs;

use App\Helpers\Log\Factory\Logs\model\BasicLog;
use App\Models\Entities\DBLogInterface;

interface LogInterface
{
    /**
     * 寫入
     *
     * @param BasicLog $log
     *
     * @return mixed
     */
    public function write(BasicLog $log);

    /**
     * 透過Queue進行儲存
     *
     * @param DBLogInterface $model
     *
     * @return mixed
     */
    public function onQueue(DBLogInterface $model);
}
