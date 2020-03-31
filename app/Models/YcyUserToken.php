<?php

namespace App\Models;

use App\Helper\Util;
use Illuminate\Database\Eloquent\Model;

class YcyUserToken extends Model
{
    protected $table      = 'ycy_user_token';
    protected $primaryKey = 'id';
    public    $timestamps = false;

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
     * @var int 项目类型，亿车商项目
     */
    const YCS_PROJECT = 1;

    public static function createToken($project, $ycyUserId, $projectUserId)
    {
        $token = md5('token_' . $ycyUserId . '_' . Util::getMillisecond() . uniqid() . self::TOKEN_SERCURE);

        $tokenData = [
            'token'           => $token,
            'project'         => $project,
            'ycy_user_id'     => $ycyUserId,
            'project_user_id' => $projectUserId,
            'status'          => 1,
            'expire_time'     => date('Y-m-d H:i:s', time() + 3600 * 24 * 30),
        ];

//        AuthAdminToken::where([
//            'admin_user_id' => $uid,
//        ])->update(['status' => 2]);

        YcyUserToken::insert($tokenData);

        return $token;
    }
}
