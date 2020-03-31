<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\YcyUsers
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $mobile 手机号
 * @property string $idcard 身份证
 * @property string $password 密码
 * @property int $status 启用状态1：启用，2：禁用
 * @property string|null $created_at 创建时间
 * @property string|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class YcyUsers extends Authenticatable
{
    protected $table      = 'ycy_users';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    /**
     * 亿车商用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ycs_user()
    {
        return $this->hasOne(YcsUsers::class, 'ycy_user_id', 'id');
    }


}
