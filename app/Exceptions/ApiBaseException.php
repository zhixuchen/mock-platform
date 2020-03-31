<?php

namespace App\Exceptions;

class ApiBaseException extends \Exception
{
    // 所有的参数统一输出错误
    const PARAM_ERR = 400;
}
