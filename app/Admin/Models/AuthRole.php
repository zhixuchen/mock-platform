<?php


namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Models\AuthRole
 *
 * @property int $id
 * @property int $is_master 是否是账号初始化的第一个角色
 * @property string $name 角色名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property int|null $is_del 删除状态
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthRole extends Model
{

    protected $table      = 'auth_role';
    protected $primaryKey = 'id';

}