<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthMenuPermission
 *
 * @property int $id
 * @property int $menu_id 菜单id
 * @property int $permission_id 权限id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthMenuPermission wherePermissionId($value)
 * @mixin \Eloquent
 */
class AuthMenuPermission extends Model
{
    protected $table = 'auth_menu_permission';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
