<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helper\Util;
use App\Models\AdminUser;
use App\Models\AuthAdminToken;

/**
 * 后台token管理
 * Class AdminTokenService
 * @package App\Services
 */
class AdminTokenService
{
    // 生成token的秘钥
    const TOKEN_SERCURE = 'GUANGGAO20189982infaadfd';

    /**
     * @var int token错误
     */
    const TOKEN_ERR = 402;
    /**
     * @var int token过期
     */
    const TOKEN_EXPIRE = 402;


    /**
     * 生成token
     * @param $uid
     * @param $type
     * @return string
     */
    public function createToken($uid)
    {
        $token = md5('token_' . $uid . '_' . Util::getMillisecond() . uniqid() . self::TOKEN_SERCURE);

        $tokenData = [
            'token'         => $token,
            'admin_user_id' => $uid,
            'status'        => 1,
            'expire_time'   => date('Y-m-d H:i:s', time() + 3600 * 24 * 30),
        ];

//        AuthAdminToken::where([
//            'admin_user_id' => $uid,
//        ])->update(['status' => 2]);

        AuthAdminToken::insert($tokenData);

        return $token;
    }

    /**
     * 检测用户token，并返回用户信息
     * @param $token
     * @return AdminUser|AdminUser[]|\Illuminate\Database\Eloquent\Collection|Model|null
     * @throws ApiException
     */
    public function checkToken($token)
    {
        if (empty($token)) {
            throw new ApiException('用户还未登录', self::TOKEN_ERR);
        }

        $tokenInfo = AuthAdminToken::select('admin_user_id', 'expire_time')->where([
            'token'  => $token,
            'status' => 1,
        ])->first();

        if (!$tokenInfo) {
            throw new ApiException('用户还未登录', self::TOKEN_ERR);
        }

        if (strtotime($tokenInfo->expire_time) < time()) {
            throw new ApiException('用户登录信息过期', self::TOKEN_EXPIRE);
        }

        $userInfo = AdminUser::where([
            'id'     => $tokenInfo->admin_user_id,
            'is_del' => 0
        ])->first();

        if (!$userInfo) {
            throw new ApiException('用户不存在');
        }
        return $userInfo;
    }
}
