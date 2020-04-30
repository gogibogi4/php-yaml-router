<?php

namespace Demo\Utils;

class JSONResponse
{
    /**
     * @param $message
     * @return string
     */
    public static function respondSuccess($message): string
    {
        header('Content-Type: application/json');

        return json_encode(
            array(
                'status'  => 'success',
                'message' => $message
            )
        );
    }
}