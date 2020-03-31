<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Admin\Models{
/**
 * App\Admin\Models\AuthMenu
 *
 * @property int $id
 * @property int $pid
 * @property int $child_action_id 针对于只有一级菜单有效
 * @property string $title
 * @property string|null $icon icon
 * @property string|null $action_key 同一个父级下唯一,给前端用
 * @property int $is_menu
 * @property int $rank
 * @property int $status 状态1：正常，2：禁用
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $icon_url icon的url地址
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Admin\Models\AuthMenu[] $children
 * @property-read int|null $children_count
 * @property-read \App\Admin\Models\AuthMenu $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Admin\Models\AuthPermission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereActionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereChildActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin\Models\AuthMenu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AuthMenu extends \Eloquent {}
}

namespace App\Admin\Models{
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
	class AuthRoleMenu extends \Eloquent {}
}

namespace App\Admin\Models{
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
	class AuthAdminUserRole extends \Eloquent {}
}

namespace App\Admin\Models{
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
	class AuthPermission extends \Eloquent {}
}

namespace App\Admin\Models{
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
	class AdminUser extends \Eloquent {}
}

namespace App\Admin\Models{
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
	class AuthRole extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SmsCode
 *
 * @property int $id
 * @property int $ycy_user_id 总管理员id
 * @property int $product 产品1：
 * @property int $type 短信用途1：登录
 * @property string $mobile 发送手机号
 * @property string $code code码
 * @property string $send_time 发送时间
 * @property string $expire_time 过期时间
 * @property string $read_time 阅读操作时间
 * @property int $state 使用状态1：使用，0：未使用
 * @property string $message 短信内容
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereExpireTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereReadTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereSendTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereYcyUserId($value)
 */
	class SmsCode extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Region
 *
 * @package App\Models
 * @property int id 自增主键
 * @property string name 区域名称
 * @property string code 区域编码
 * @property string parent_code 城市编码
 * @property int level 城市等级：1省份，2城市，3区
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region query()
 * @mixin \Eloquent
 * @property int $id 自增主键
 * @property string $name 区域名称
 * @property string $code 区域编码
 * @property string $parent_code 城市编码
 * @property int $level 城市等级：1省份，2城市，3区
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Region whereParentCode($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
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
	class AuthRoleMenu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AuthAdminToken
 *
 * @property int $id
 * @property int $status 1:有效，2：无效
 * @property int $admin_user_id 后台用户id
 * @property string $token md5,
 * @property string $expire_time 过期时间
 * @property string $device 登录的设备信息
 * @property string $from 登录来源，分phone,pad,web
 * @property string $ip 登陆ip
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereExpireTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AuthAdminToken extends \Eloquent {}
}

namespace App\Models{
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
	class YcsUsers extends \Eloquent {}
}

namespace App\Models{
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
	class AuthMenuPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AuthAdminUserRole
 *
 * @property int $id
 * @property int $admin_user_id 用户id
 * @property int $role_id 用户角色
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property int $is_del 1:删除
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AuthAdminUserRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AuthAdminUserRole extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\YcyUsers
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $mobile 手机号
 * @property string $idcard 身份证
 * @property string $password 密码
 * @property int $status 启用状态1：启用，2：禁用
 * @property string|null $created_at 创建时间
 * @property string|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\YcyUsers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class YcyUsers extends \Eloquent {}
}

namespace App\Models{
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
	class AuthPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * Class AdminUser
 *
 * @package App\Models
 * @property string password
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
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_del 1  代表删除 0 代表未删除
 * @property string $data_permission 数据访问权限：0无数据访问权限，1本人业务数据，2组织数据，3：所有,json
 * @property int|null $auth_organize_id 组织id
 * @property string $province_code 省级code
 * @property string $province_name 省份
 * @property string $city_code 市级code
 * @property string $city_name 市
 * @property string|null $header_url 头像路径
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AuthRole[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereAuthOrganizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCreatedAdminUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCreatedAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereDataPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereDelAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereEntryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereHeaderUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereProvinceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdminUser extends \Eloquent {}
}

namespace App\Models{
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
	class AuthRole extends \Eloquent {}
}

