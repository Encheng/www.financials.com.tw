<?php

namespace App\Helpers\Log\Factory\Logs;

use App\Helpers\Log\Factory\Logs\model\BasicLog;

abstract class AbstractLog
{
    /**
     * 寫入db
     *
     * @param BasicLog $log
     *
     * @return mixed|void
     */
    public function write(BasicLog $log)
    {
        $this->onQueue($this->convertBasicLog($log));
    }

    /**
     * 轉換log資料格式
     *
     * @param BasicLog $log
     *
     * @return mixed
     */
    abstract protected function convertBasicLog(BasicLog $log);
}
