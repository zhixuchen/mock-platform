<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthPermission
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
 * @property string $created_at 创建时间
 * @property string|null $updated_at
 * @property int|null $rank 排序，正序
 * @property int|null $is_del 1：删除
 * @property int $is_check 是否需要验证权限（公用接口）1：是，0：否
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereHttpMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereHttpPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereIsCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthPermission extends Model
{
    protected $table = 'auth_permission';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
