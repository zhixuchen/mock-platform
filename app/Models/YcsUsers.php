<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\YcsUsers
 *
 * @property int $id
 * @property int $ycy_user_id 亿车云总用户id
 * @property int $status 启用状态1：启用2：禁用
 * @property string $invite_mobile 邀请人手机号
 * @property string $invite_name 邀请人姓名
 * @property string|null $created_at 注册时间
 * @property string|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereInviteMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereInviteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcsUsers whereYcyUserId($value)
 * @mixin \Eloquent
 */
class YcsUsers extends Model
{
    protected $table      = 'ycs_users';
    protected $primaryKey = 'id';
    public    $timestamps = false;

}
