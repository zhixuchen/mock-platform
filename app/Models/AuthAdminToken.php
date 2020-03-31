<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthAdminToken
 *
 * @property int $id
 * @property int $status 1:有效，2：无效
 * @property int $admin_user_id 后台用户id
 * @property string $token md5,
 * @property string $expire_time 过期时间
 * @property string $device 登录的设备信息
 * @property string $from 登录来源，分phone,pad,web
 * @property string $ip 登陆ip
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereExpireTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthAdminToken extends Model
{
    protected $table = 'auth_admin_token';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const TOKEN_EXPIRED = 2;
    const TOKEN_NOT_EXPIRED = 1;

    public function setExpired()
    {
        $this->status = self::TOKEN_EXPIRED;
        return $this->save();
    }

}
