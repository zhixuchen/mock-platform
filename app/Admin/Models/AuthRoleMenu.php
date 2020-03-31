<?php


namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Models\AuthRoleMenu
 *
 * @property int $role_id 角色id
 * @property int $menu_id 菜单id
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property int $is_del 删除状态
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRoleMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthRoleMenu extends Model
{

    protected $table      = 'auth_role_menu';
    protected $primaryKey = 'id';

}