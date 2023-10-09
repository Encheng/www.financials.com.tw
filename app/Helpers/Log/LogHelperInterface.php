<?php

namespace App\Helpers\Log;

use App\Models\Entities\UserInterface;

/**
 * Interface LogHelperInterface
 * @package App\Helpers\Log
 */
interface LogHelperInterface
{
    /**
     * 是否將資料同步寫入資料庫
     *
     * @param string $type ; LogFactory const
     *
     * @return void
     */
    public function setWriteToDB(string $type);

    /**
     * 設定當前操作的人員
     *
     * @param UserInterface $user
     *
     * @return mixed
     */
    public function setOperateUser(UserInterface $user);

    /**
     * 緊急
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return mixed
     */
    public function emergency($type, $msg, $info = []);

    /**
     * 提示
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return mixed
     */
    public function alert($type, $msg, $info = []);

    /**
     * 關鍵
     *
     * @param $type
     * @param $msg
     * @param $info
     *
     * @return mixed
     */
    public function critical($type, $msg, $info = []);

    /**
     * 錯誤
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return mixed
     */
    public function error($type, $msg, $info = []);

    /**
     * 警告
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return void
     */
    public function warning($type, $msg, $info = []);

    /**
     * 注意
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     * @param bool   $toDB
     *
     * @return void
     */
    public function notice($type, $msg, $info = [], $toDB = false);

    /**
     * 訊息
     *
     * @param string $type
     * @param string $msg
     * @param mixed  $info
     *
     * @return mixed
     */
    public function info($type, $msg, $info = []);
}
