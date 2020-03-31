<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Model;

class SmsCode extends Model
{
    protected $table      = 'sms_code';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    /**
     * @var int 项目类型，亿车商项目
     */
    const YCS_PROJECT = 1;

    /**
     * @var int 发送短信类型
     */
    const LOGIN = 1;
    const REG   = 2;

    public static function checkSMSCode($code, $mobile, $type, $project)
    {
        //验证手机号
        $sms = self::select('id', 'expire_time', 'state')
            ->where([
                'type'    => $type,
                'mobile'  => $mobile,
                'code'    => $code,
                'project' => $project
            ])->orderBy('id', 'desc')->first();
        if (!$sms) {
            throw new ApiException('请输入正确的验证码');
        }
        if ($sms->state == 1) {
            throw new ApiException('该验证码已经使用过');
        }
        if (strtotime($sms->expire_time) < time()) {
            throw new ApiException('该验证码已过期');
        }
    }

    public static function useSMSCode($code, $mobile, $type, $project)
    {
        self::where([
            'type'    => $type,
            'mobile'  => $mobile,
            'code'    => $code,
            'project' => $project,
        ])->update(['state' => 1, 'read_time' => date('Y-m-d H:i:s', time())]);
    }
}
