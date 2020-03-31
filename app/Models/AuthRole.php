<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\AuthRole
 *
 * @property int $id
 * @property int $is_master 是否是账号初始化的第一个角色
 * @property string $name 角色名
 * @property string|null $created_at
 * @property string|null $updated_at 更新时间
 * @property int|null $is_del 删除状态
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AuthAdminUserRole[] $role_users
 * @property-read int|null $role_users_count
 * @property-read \App\Models\AuthAdminUserRole $user_num
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthRole extends Model
{
    protected $table      = 'auth_role';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    protected $hidden = ['pivot'];


    public function user_num()
    {
        return $this->hasOne(AuthAdminUserRole::class, 'role_id', 'id')
            ->select('*', DB::raw("count(admin_user.id) as user_num"))
            ->join('admin_user', 'admin_user.id', '=', 'auth_admin_user_role.admin_user_id')
            ->where([
                'admin_user.is_del'           => 0,
                'auth_admin_user_role.is_del' => 0,
            ])->groupBy('admin_user.id');
    }

    public function role_users()
    {
        return $this->hasMany(AuthAdminUserRole::class, 'role_id', 'id');
    }
}
