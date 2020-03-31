<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthRoleMenu
 *
 * @property int $role_id 角色id
 * @property int $menu_id 菜单id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property int $is_del 删除状态
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthRoleMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthRoleMenu extends Model
{
    protected $table = 'auth_role_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
