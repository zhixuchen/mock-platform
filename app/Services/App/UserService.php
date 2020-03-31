<?php


namespace App\Services\App;


use App\Exceptions\ApiException;
use App\Helper\Util;
use App\Models\YcsUsers;
use App\Models\YcyUsers;
use App\Models\YcyUserToken;

class UserService
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
     * 亿车商登录
     * @param YcyUsers $ycyUser
     * @return array
     * @throws ApiException
     */
    public function ycsLogin(YcyUsers $ycyUser)
    {
        $ycsUser = YcsUsers::where('ycy_user_id', $ycyUser->id)->first();
        if (empty($ycsUser)) { // 多项目共享账号
//            throw new ApiException('该手机号还未注册，请先注册');
            $ycsUser = $this->ycsReg($ycyUser, []);
        }
        $token = YcyUserToken::createToken(YcyUserToken::YCS_PROJECT, $ycyUser->id, $ycsUser->id);
        $alias = Util::appPushAlias($ycyUser->mobile, 'ycs');
        return [
            'token'   => $token,
            'gtAlias' => $alias
        ];
    }

    /**
     * 亿车云登录信息
     * @param $mobile
     * @param callable $verify
     * @return YcyUsers
     * @throws ApiException
     */
    public function ycyLogin($mobile, callable $verify): YcyUsers
    {
        $ycyUser = YcyUsers::where('mobile', $mobile)->first();
        if (empty($ycyUser)) {
            throw new ApiException('该手机号还未注册，请先注册');
        }
        $verify($ycyUser);

        return $ycyUser;
    }

    /**
     * yiche云总用户表注册
     * @param string $mobile
     * @param array $info
     * @return YcyUsers
     */
    public function ycyReg(string $mobile, $info = []): YcyUsers
    {
        $ycyUserModel = new YcyUsers();

        $ycyUserInfo = $ycyUserModel->where('mobile', $mobile)->first();
        if ($ycyUserInfo) {
            return $ycyUserInfo;
        }

        $ycyFields            = [
            'idcard',
            'password'
        ];
        $ycyUserModel->mobile = $mobile;
        foreach ($ycyFields as $field) {
            if (isset($info[$field])) {
                $ycyUserModel->$field = $info[$field];
            }
        }
        $ycyUserModel->save();

        return $ycyUserModel;

    }


    /**
     *
     * 亿车上注册
     * @param YcyUsers $ycyUsers
     * @param $info
     * @return YcsUsers
     * @throws ApiException
     */
    public function ycsReg(YcyUsers $ycyUsers, $info): YcsUsers
    {
        $ycsModel    = new YcsUsers();
        $ycsFields   = [
            'invite_mobile',
            'invite_name'
        ];
        $ycsUserInfo = $ycsModel->where('ycy_user_id', $ycyUsers->id)->first();
        if (!empty($ycsUserInfo)) {
            throw new ApiException('您已经注册过APP，请直接登录');
        }

        $ycsModel->ycy_user_id = $ycyUsers->id;
        foreach ($ycsFields as $field) {
            if (isset($info[$field])) {
                $ycsModel->$field = $info[$field];
            }
        }
        $ycsModel->save();
        return $ycsModel;
    }


    /**
     * 亿车商token检测
     * @param $token
     * @return YcyUsers
     * @throws ApiException
     */
    public function checkYcsToken($token): YcyUsers
    {
        if (empty($token)) {
            throw new ApiException('用户还未登录', self::TOKEN_ERR);
        }

        $tokenInfo = YcyUserToken::select('ycy_user_id', 'project', 'project_user_id', 'expire_time')->where([
            'token'  => $token,
            'status' => 1,
        ])->first();
        if (!$tokenInfo) {
            throw new ApiException('用户还未登录', self::TOKEN_ERR);
        }
        if (strtotime($tokenInfo->expire_time) < time()) {
            throw new ApiException('用户登录信息过期', self::TOKEN_EXPIRE);
        }
        $userInfo = YcyUsers::where([
            'id' => $tokenInfo->ycy_user_id,
        ])->with('ycs_user')->first();

        if (!$userInfo || empty($userInfo->ycs_user)) {
            throw new ApiException('用户不存在');
        }
        if ($userInfo->status != 1 || $userInfo->ycs_user->status != 1) {
            throw new ApiException('用户已经被禁用');
        }
        return $userInfo;
    }
}