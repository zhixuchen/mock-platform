<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Models\AuthAdminToken;
use App\Services\AdminService;
use App\Services\AdminTokenService;
use App\Services\App\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yiche\Config\Models\SapiConfig;

class AppYcsAuth
{
    /**
     * API权限验证中间件
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ApiException
     */
    const AUTHORIZATION = 'token';

    public function handle(Request $request, Closure $next)
    {
        $route = trim($request->path(), '/');
        $this->_checkToken($request, new UserService());
        $this->_checkPrimission($route, $request);
        return $next($request);
    }


    /**
     * 用户token检测
     * @param Request $request
     * @throws ApiException
     */
    private function _checkToken(Request $request, UserService $userService)
    {
        $token = $request->header(self::AUTHORIZATION);

        if (empty($token)) {
            $token = $request->input(self::AUTHORIZATION);
        }
        $userInfo = $userService->checkYcsToken($token);
        Auth::setUser($userInfo);
    }

    /**
     * 检测角色权限
     * @param         $route
     * @param Request $request
     */
    private function _checkPrimission($route, Request $request)
    {
    }


}
