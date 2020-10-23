<?php

declare(strict_types=1);

use App\Exceptions\HttpException;


if (!function_exists('abortHttp')) {
    /**
     * @param      $status
     * @param null $message
     */
    function abortHttp($status, $message = null)
    {
        throw new HttpException($status, $message);
    }
}

