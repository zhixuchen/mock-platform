<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsTemplateConfig extends Model
{
    protected $table      = 'sms_template_config';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    /**
     * 注册短信配置name
     */
    const REG_NAME = 'reg';
    /**
     * 登录
     */
    const LOGIN_NAME = 'login';

    public static function getConfig($name, $project)
    {
        return self::where(['name' => $name, 'project' => $project])->first();
    }
}
