<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


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
 * App\Models\MockCallback
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $name
 * @property string|null $request_uri
 * @property string|null $request_body
 * @property string|null $parameter
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereParameter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereRequestUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockCallback whereStatus($value)
 * @mixin \Eloquent
 */
	class MockCallback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MockProjectMethod
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $name
 * @property string|null $uri
 * @property string|null $route
 * @property int $type 1:同步响应；2：异步回调
 * @property string|null $result
 * @property string|null $parameter 变化的参数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereParameter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProjectMethod whereUri($value)
 * @mixin \Eloquent
 */
	class MockProjectMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MockProject
 *
 * @property int $id
 * @property string|null $project 项目名
 * @property string|null $name 项目中文名
 * @property string|null $rule
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockProject whereRule($value)
 * @mixin \Eloquent
 */
	class MockProject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MockRequestLog
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $method_id
 * @property string|null $name
 * @property string|null $request_url
 * @property string|null $request_body
 * @property string|null $request_method
 * @property string|null $response
 * @property string|null $creat_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereCreatTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereRequestMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereRequestUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MockRequestLog whereType($value)
 * @mixin \Eloquent
 */
	class MockRequestLog extends \Eloquent {}
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

namespace App{
/**
 * App\AppModelsMockProject
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppModelsMockProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppModelsMockProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppModelsMockProject query()
 * @mixin \Eloquent
 */
	class AppModelsMockProject extends \Eloquent {}
}

