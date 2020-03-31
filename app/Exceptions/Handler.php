<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        ApiException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $uri    = $request->getRequestUri();
        $params = explode("/", $uri);

        $adminRoutePrefix    = config('admin.route.prefix');
        $businessRoutePrefix = config('tenancy.route.prefix');
        if (isset($params[1]) && in_array(strtolower($params[1]), [$adminRoutePrefix, $businessRoutePrefix])) {
            return parent::render($request, $exception);
        }
        return HandlerHook::specilException($request, $exception);
//        return parent::render($request, $exception);
    }
}
