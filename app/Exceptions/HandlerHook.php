<?php

namespace App\Exceptions;

use App\Helper\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Psy\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HandlerHook
{
    use ApiResponse;

    /**
     * 处理特定异常的结构
     * @param $request
     */
    public static function specilException(Request $request, Exception $exception)
    {
//        Log::info('异常：' . $exception->getMessage() . "\r\n详细信息" . $exception->getTraceAsString());
        Log::info('异常：' . $exception->getMessage());

        // 自定义异常
        if ($exception instanceof ApiException) {
            return ApiResponse::out([], $exception->getCode() ?? 400, $exception->getMessage(), [], false);
        }

        // 404异常
        if ($exception instanceof NotFoundHttpException) {
            return ApiResponse::out([], 404, '接口调用错误', [], false);
        }

        // 请求方式错误异常
        if ($exception instanceof MethodNotAllowedHttpException) {
            Log::error('404：' . $exception->getHeaders()['Allow']);
            return ApiResponse::out([], 400, '错误的请求方式', ['Allow' => $exception->getHeaders()['Allow']], [], false);
        }

        //校验失败
        if ($exception instanceof ValidationException) {
            $message = $exception->validator->errors()->first();
            \Log::error(ApiBaseException::PARAM_ERR . ':' . $message);
            return ApiResponse::out([], ApiBaseException::PARAM_ERR, $message);
        }

        // 自定义异常
        if ($exception instanceof ApiBaseException) {
            return ApiResponse::out([], $exception->getCode(), [], false);
        }
        // 500异常
        if ($exception instanceof FatalErrorException) {
            \Log::error('500:' . $exception->getMessage());
            return ApiResponse::out([], 500, '服务异常', [
                '_message' => $exception->getMessage(),
                '_url' => $request->fullUrl(),
                '_line' => $exception->getLine(),
                '_file' => $exception->getFile(),
            ], false);
        }
        return self::defaultException($request, $exception);
    }

    /**
     * 未知异常
     * @param Request $request
     * @param Exception $exception
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public static function defaultException(Request $request, Exception $exception)
    {
        if ($exception instanceof \Exception) {
            return ApiResponse::out([], 500, '接口异常', [
                '_message' => $exception->getMessage(),
                '_url' => $request->fullUrl(),
                '_line' => $exception->getLine(),
                '_file' => $exception->getFile(),
            ], false);
        }
    }


}
