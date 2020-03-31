<?php

namespace App\Exceptions;

class ApiException extends ApiBaseException
{
    public function __construct($message = "", $code = 400, \Throwable $previous = null)
    {
        $this->code = $code;
        parent::__construct($message, $code, $previous);
    }
}
