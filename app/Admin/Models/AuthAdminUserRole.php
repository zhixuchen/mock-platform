<?php


namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Models\AuthAdminUserRole
 *
 * @property int $id
 * @property int $admin_user_id 用户id
 * @property int $role_id 用户角色
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property int $is_del 1:删除
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthAdminUserRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthAdminUserRole extends Model
{

    protected $table      = 'auth_admin_user_role';
    protected $primaryKey = 'id';

}