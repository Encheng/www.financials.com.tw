<?php

namespace App\Helpers\Log\Factory;

use App\Helpers\Log\Factory\Logs\AdminLog;
use App\Helpers\Log\Factory\Logs\LogInterface;

class LogFactory
{
    public const ADMIN = 'ADMIN';
    public const WEB = 'WEB';

    /**
     * @param string $target
     *
     * @return LogInterface
     */
    public static function create($target)
    {
        switch ($target) {
            case self::ADMIN:
                return app(AdminLog::class);
            case self::WEB:
                // todo implements
                break;
        }
    }
}
