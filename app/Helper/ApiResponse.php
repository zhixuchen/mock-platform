<?php

namespace App\Helper;

use Illuminate\Http\Resources\Json\Resource;

trait ApiResponse
{
    /**
     * 对于资源的统一输出
     * @param $resource
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseWithResource($resource)
    {
        return self::out($resource);
    }

    /**
     * 响应输出
     * @param  $result
     * @param int $code
     * @param string $msg
     * @param array $debug
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @return \Illuminate\Http\Response
     */
    public static function out($result = true, $code = 200, $msg = '', $debug = [])
    {
        $output = [
            'success' => $code == 200 ? true : false,
            'code' => (int)$code,
            'message' => $msg,
            'result' => $result,
        ];
        if (config('app.debug')) {
            $output['_debug'] = $debug;
        }
        response()->json($output)->send();
    }

    public function success($data = [], $code = 200, $msg = '')
    {
        return ApiResponse::out($data, $code, $msg ?: '调用成功');
    }

    public function error($msg = '', $code = 400, $data = [])
    {
        return ApiResponse::out($data, $code, $msg ?: '调用失败');
    }
}
