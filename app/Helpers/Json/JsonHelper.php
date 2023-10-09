<?php

namespace App\Helpers\Json;

use stdClass;

class JsonHelper
{
    /**
     * Encode all
     *
     * @param array|stdClass $data
     *
     * @return false|string
     */
    public static function encoder($data)
    {
        $coder = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE;

        return json_encode($data, $coder);
    }

    /**
     * 檢查字串是否能夠json_decode
     *
     * @param mixed $string
     *
     * @return bool
     */
    public static function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }

        json_decode($string);

        return (json_last_error() === JSON_ERROR_NONE);
    }
}
