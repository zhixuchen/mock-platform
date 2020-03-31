<?php


namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Models\AuthPermission
 *
 * @property int $id
 * @property int $pid 父级id
 * @property int $is_menu 是否是菜单
 * @property string $code 对应的code码
 * @property string $menu_name
 * @property string $name 菜单名
 * @property string $http_method 暂时用不到
 * @property string $http_path 接口地址
 * @property string|null $params 验证的参数，json，同一个接口不同参数实现不同功能
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $rank 排序，正序
 * @property int|null $is_del 1：删除
 * @property int $is_check 是否需要验证权限（公用接口）1：是，0：否
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereHttpMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereHttpPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereIsCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthPermission extends Model
{
    protected $table      = 'auth_permission';
    protected $primaryKey = 'id';
}