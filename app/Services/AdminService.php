<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helper\Util;
use App\Models\AdminSmsCode;
use App\Models\AdminUser;
use App\Models\AppMenu;
use App\Models\AppRoleMenu;
use App\Models\AuthAdminUserRole;
use App\Models\AuthMenu;
use App\Models\AuthMenuPermission;
use App\Models\AuthPermission;
use App\Models\AuthRole;
use App\Models\AuthRoleMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class AdminService
{


    public function codeLogin($account, $password)
    {
        throw new ApiException('验证码登录还未上线，请使用密码登录');
    }

    /**
     * 账号登录
     * @param $account
     * @param $password
     * @return array
     * @throws ApiException
     */
    public function accountLogin($account, $password)
    {
        $exist = AdminUser::where('mobile', $account)->where('is_del', 0)->count();
        if (!$exist) {
            throw new ApiException('用户不存在');
        }
        $adminInfo = AdminUser::select(
            'id',
            'password',
            'name',
            'is_master',
            'mobile',
            'is_active',
            'header_url as avatar'
        )
            ->where([
                'mobile' => $account,
                'is_del' => 0
            ])
            ->first();
        if (!empty($adminInfo) && Util::userPwdVerify($password, $adminInfo->password)) {
            return $this->loginInfo($adminInfo);
        }

        throw new ApiException('账号或密码输入错误，或账户被禁用，请联系管理员');
    }


    /**
     * 登录业务处理
     * @param AdminUser $adminInfo
     * @return array
     * @throws ApiException
     */
    public function loginInfo(AdminUser $adminInfo)
    {
        if ($adminInfo->is_active != 1) {
            throw new ApiException('账号已被禁用，请联系管理员');
        }

        $adminTokenService = new AdminTokenService();
        $token = $adminTokenService->createToken($adminInfo->id);
        unset($adminInfo->password);
        return [
            'token' => $token,
            'user_info' => $adminInfo,
        ];
    }



    /**
     * 获取admin详情
     */
    public function getAdminInfo($adminId)
    {
        $adminUser = AdminUser::find($adminId);
        $ret = [
            'id' => $adminUser->id,
            'name' => $adminUser->name,
            'mobile' => $adminUser->mobile,
            'district' => !empty($adminUser->province_name) ? $adminUser->province_name . ' ' . $adminUser->city_name : '',
        ];
        return $ret;
    }

    /**
     * 获取用户拥有角色id
     * @param int $uid 用户id
     * @return array   角色id
     */
    public static function userRoleIds($uid = 0)
    {
        $list = self::userRole($uid);
        $roleIds = array_column($list, 'role_id');

        return $roleIds;
    }


    /**
     * 获取公司角色列表
     * @return \Illuminate\Support\Collection
     */
    public static function listCompanyRole()
    {
        return AuthRole::select('id', 'name')
            ->where([
                'is_master' => 0,
                'is_del' => 0,
            ])
            ->get();
    }

    /**
     * 获取公司角色带账号数量
     * @return array
     */
    public static function listCompanyRoleWithUserNum()
    {
        $list = AuthRole::select('id as value', 'name as label')
            ->withCount('role_users as account_num')
            ->where([
                'is_master' => 0,
                'is_del' => 0,
            ])
            ->get();
        return $list;
    }

    /**
     * 获取用户角色
     * @param $uid
     * @return array
     */
    public static function userRole($uid)
    {
        $list = AuthAdminUserRole::select('role_id')
            ->where([
                'admin_user_id' => $uid,
                'is_del' => 0,
            ])->get()
            ->toArray();

        return $list;
    }


    /**
     * 检测当前路由是否有权限
     * @param       $uid
     * @param       $route
     * @param array $params
     * @throws ApiException
     */
    public static function checkPermission($uid, $route, $params = [])
    {
        $userPermissions = self::permissionKeyArrDecorator($uid);

        $route = trim($route, '/');
        $route = str_replace(" ", "", $route);
        if (!isset($userPermissions[$route])) {
            throw new ApiException('没有权限');
        }
        $routeParams = $userPermissions[$route]['params'];
        $routeParams = (array_unique($routeParams));
        $hasPermission = true;
        // 参数最小规则匹配
        foreach ($routeParams as $k => $param) {
            // 如果有权限参数不存在，则可以表是传递任何参数
            $param = json_decode($param, true);
            if (empty($param) || !is_array($param)) {
                $hasPermission = true;
                break;
            }
            $theRouteHasPer = true;

            // 这是一个路由参数
            foreach ($param as $p => $v) {
                if (!isset($params[$p]) || $params[$p] != $v) {
                    $theRouteHasPer = false;
                    break;
                }
            }

            if ($theRouteHasPer) {
                $hasPermission = true;
                break;
            } else {
                $hasPermission = false;
            }
        }

        if ($hasPermission == false) {
            throw new ApiException('没有权限');
        }
    }

    /**
     * 获取WEB用户菜单
     * @param $uid
     * @return array
     */
    public static function getUserMenu($uid)
    {
        $roleIds = self::userRoleIds($uid);
        $menu = self::roleMenu($roleIds);
        // 获取master角色权限
        $masterRole = AuthRole::where([
            'is_del' => 0,
            'is_master' => 1
        ])->first();
        if (empty($masterRole)) {
            return [];
        }
        $masterRoleMenu = self::roleMenu([$masterRole->id]);
        $masterRoleMenuIds = array_column($masterRoleMenu, 'id');

        $returnMenu = [];
        foreach ($menu as $k => $v) {
            if (in_array($v['id'], $masterRoleMenuIds)) {
                $returnMenu[] = $v;
            }
        }
        return self::tree($returnMenu);
    }



    /**
     * 获取角色菜单
     * @param $rolds
     * @return array
     */
    public static function roleMenu($rolds)
    {
        return AuthRoleMenu::from('auth_role_menu as a')
            ->select(
                'b.id',
                'b.pid',
                'b.title',
                'b.action_key as name',
                'b.is_menu',
                'b.child_action_id as index',
                'b.icon'
            )
            ->distinct()
            ->join('auth_menu as b', 'a.menu_id', '=', 'b.id')
            ->whereIn('a.role_id', $rolds)
            ->where([
                'a.is_del' => 0,
                'b.status' => 1,
            ])
            ->orderBy('b.rank', 'asc')
            ->orderBy('b.id', 'asc')
            ->get()->toArray();
    }


    /**
     * 获取菜单节点
     * @return array
     */
    public static function menu()
    {
        return AuthMenu::select('id', 'pid', 'title', 'action_key as name', 'is_menu', 'child_action_id as index')
            ->where([
                'status' => 1,
            ])
            ->get()->toArray();
    }


    // 装饰模式获取缓存数据
    public static function permissionKeyArrDecorator($uid)
    {
        $permissionList = self::permissionKeyArr($uid);
        return $permissionList;
    }

    /**
     * 返回用户拥有的权限列表[trim('http_path', '/')=>$params]
     * @param $uid
     * @return array
     */
    public static function permissionKeyArr($uid)
    {

        $permissionList = self::userPermissions($uid);
        $formate = [];
        foreach ($permissionList as $k => $v) {
            if (!empty($v['http_path'])) {
                $formate[trim(
                    $v['http_path'],
                    '/'
                )]['params'][] = $v['params'];
            }
        }

        return $formate;
    }

    /**
     * 获取用户权限列表
     * @param int $uid
     * @return array
     */
    public static function userPermissions($uid = 0)
    {
        $roleIds = self::userRoleIds($uid);
        // 1.获取用户所有的菜单
        $rolesMenu = self::roleMenu($roleIds);

        // 获取master角色权限，过滤master
        $masterRole = AuthRole::where([
            'is_del' => 0,
            'company_id' => Auth::user()->company_id,
            'is_master' => 1
        ])->first();
        if (empty($masterRole)) {
            $rolesMenu = [];
        } else {
            $masterRoleMenu = self::roleMenu([$masterRole->id]);
            $masterRoleMenuIds = array_column($masterRoleMenu, 'id');
            $returnMenu = [];
            foreach ($rolesMenu as $k => $v) {
                if (in_array($v['id'], $masterRoleMenuIds)) {
                    $returnMenu[] = $v;
                }
            }
            $rolesMenu = $returnMenu;
        }

        // 2.根据菜单id获取所有的权限节点
        $menuPermission = AuthMenuPermission::select('permission_id')
            ->whereIn('menu_id', array_column($rolesMenu, 'id'))
            ->get()->toArray();

        $fields = [
            'id',
            'http_path',
            'params',
        ];
        // 3.根据所有的权限节点获取权限
        return AuthPermission::select($fields)->whereIn('id', array_column($menuPermission, 'permission_id'))
            ->orWhere('is_check', 0)
            ->get()->toArray();
    }

    /**
     * 组合菜单数据
     * @param        $list
     * @param string $name
     * @param int $pid
     * @return array
     */
    public static function tree($list, $name = 'children', $pid = 0)
    {
        $arr = [];
        foreach ($list as $k => $v) {
            if ($v['pid'] == $pid) {
                $v[$name] = self::tree($list, $name, $v['id']);
                $arr[] = $v;
            }
        }

        return $arr;
    }


    /**
     * edit pwd
     *
     * @param AdminUser $adminUser
     * @param $oldPwd
     * @param $newPwd
     * @return bool
     * @throws ApiException
     */
    public static function editPwd(AdminUser $adminUser, $oldPwd, $newPwd)
    {
        if (false == Util::userPwdVerify($oldPwd, $adminUser->password)) {
            throw new ApiException('旧密码错误');
        }
        if (true == Util::userPwdVerify($newPwd, $adminUser->password)) {
//            throw new ApiException('新密码不能与旧密码相同');
        }
        $adminUser->editPwd($newPwd);
        return true;
    }


}
