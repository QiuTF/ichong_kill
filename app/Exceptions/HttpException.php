<?php

namespace App\Exceptions;

class HttpException extends \Exception
{
    public function __construct($code = 200, $msg = '')
    {
        $this->errorMsg = $msg;
        $this->errorCode = $code;

        parent::__construct($msg);
    }
}
