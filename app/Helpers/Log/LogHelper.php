<?php

namespace App\Helpers\Log;

use App\Helpers\Log\Factory\LogFactory;
use App\Helpers\Log\Factory\Logs\LogInterface;
use App\Helpers\Log\Factory\Logs\model\BasicLog;
use App\Models\Entities\UserInterface;
use Exception;
use JsonHelper;
use Log;
use Throwable;

class LogHelper implements LogHelperInterface
{
    public const EMERGENCY = 'EMERGENCY';
    public const ALERT = 'ALERT';
    public const CRITICAL = 'CRITICAL';
    public const ERROR = 'ERROR';
    public const WARNING = 'WARNING';
    public const NOTICE = 'NOTICE';
    public const INFO = 'INFO';

    /** @var null|LogInterface $dbLogFactory */
    private $dbLogFactory = null;

    protected $user;
    protected $log;

    /**
     * 是否將資料同步寫入資料庫
     *
     * @param string $type ; LogFactory const
     *
     * @return void
     */
    public function setWriteToDB(string $type)
    {
        if (($type !== LogFactory::ADMIN) && ($type !== LogFactory::WEB)) {
            return;
        }
        $this->writeToDB = true;
        $this->dbLogFactory = LogFactory::create($type);
    }

    /**
     * 設定當前操作的人員
     *
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function setOperateUser(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function setLogModel($model)
    {
        $this->writeModel = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function emergency($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::EMERGENCY, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::EMERGENCY);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function alert($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::ALERT, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::ALERT);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function critical($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::CRITICAL, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::CRITICAL);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function error($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::ERROR, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::ERROR);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function warning($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::WARNING, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::WARNING);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function notice($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::NOTICE, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::NOTICE);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function info($type, $msg, $info = [], $toDB = false)
    {
        $this->writeLog(self::INFO, $type, $msg, $info);
        if ($toDB) {
            $this->writeDB(self::INFO);
        }
    }

    /**
     * @param string $logType
     * @param string $type
     * @param string $msg
     * @param array  $info
     */
    private function writeLog($logType, $type, $msg, $info = [])
    {
        try {
            if (!$this->checkLogType($logType)) {
                throw new Exception('invalid log type.');
            }

            $logType = strtolower($logType);
            Log::{$logType}($this->template($type, $msg, $info));
        } catch (Exception $exception) {
            // do nothing.
        } catch (Throwable $exception) {
            // do nothing.
        }
    }

    /**
     * 將log寫入db
     *
     * @param string $level
     *
     * @return null
     */
    protected function writeDB($level)
    {
        if (!$this->dbLogFactory instanceof LogInterface) {
            return null;
        }

        $log = new BasicLog();
        $log->user = $this->user;
        $log->level = $level;
        $log->description = $this->log['message'];
        $log->json_info = $this->log['json'];
        $log->class_path = $this->log['type'];

        $this->dbLogFactory->write($log);
    }

    /**
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return array
     */
    private function template($type, $msg, $info = [])
    {
        $this->log = ['type' => $type, 'message' => $msg, 'json' => self::getData($info)];

        return $this->log;
    }

    /**
     * 將資料轉譯為json格式，若失敗直接回傳原始資料
     *
     * @param $data
     *
     * @return string|null
     */
    private static function getData($data)
    {
        if (blank($data)) {
            return null;
        }

        $encoded = JsonHelper::encoder($data);

        return (is_string($encoded)) ? $encoded : $data;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    private function checkLogType(string $type): bool
    {
        return in_array(strtoupper($type), [
            self::EMERGENCY,
            self::ALERT,
            self::CRITICAL,
            self::ERROR,
            self::WARNING,
            self::NOTICE,
            self::INFO,
        ], true);
    }
}
