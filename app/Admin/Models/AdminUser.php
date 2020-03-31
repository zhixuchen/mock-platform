<?php


namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Models\AdminUser
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $password 密码
 * @property string $idcard 身份证
 * @property string $entry_time 入职时间
 * @property int $is_master 是否 公司初始化账号 0 否 1 是
 * @property int $is_active 是否启用 0 否 1 是
 * @property int $created_admin_user_id 创建用户 的用户id
 * @property string $created_admin_user 创建用户 的用户 的用户名
 * @property int $del_admin_user_id 删除用户 的用户id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $is_del 1  代表删除 0 代表未删除
 * @property string $data_permission 数据访问权限：0无数据访问权限，1本人业务数据，2组织数据，3：所有,json
 * @property int|null $auth_organize_id 组织id
 * @property string $province_code 省级code
 * @property string $province_name 省份
 * @property string $city_code 市级code
 * @property string $city_name 市
 * @property string|null $header_url 头像路径
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereAuthOrganizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereCreatedAdminUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereCreatedAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereDataPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereDelAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereEntryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereHeaderUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereProvinceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AdminUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminUser extends Model
{

    protected $table      = 'admin_user';
    protected $primaryKey = 'id';

}