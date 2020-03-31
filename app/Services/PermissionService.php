<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\AdminUser;
use App\Models\AuthAdminUserRole;
use App\Models\AuthRole;
use App\Models\AuthRoleMenu;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    /**
     * 获取公司角色配置节点
     * @param $companyId
     * @return array
     * @throws ApiException
     */
    public function companyMasterRolePermission()
    {
        $masterRole = AuthRole::where(['is_master' => 1, 'is_del' => 0])->first();
        if (empty($masterRole)) {
            return [];
//            throw new ApiException('公司没有初始化角色');
        }
        $menu = AdminService::roleMenu([$masterRole->id]);
        $treeMenu = AdminService::tree($menu);

        return $treeMenu;
    }

    /**
     * 获取公司APP角色配置节点
     * @param $companyId
     */
    public function companyMasterAppRolePermission()
    {
        $masterRole = AuthRole::where(['is_master' => 1, 'is_del' => 0])->first();
        if (empty($masterRole)) {
            return [];
        }
        $menu = AdminService::roleAppMenu([$masterRole->id]);
        $formatMenu = [];
        foreach ($menu as $k => $v) {
            $formatMenu[] = [
                'id' => $v['id'],
                'pid' => $v['pid'],
                'title' => $v['service_name'],
                'name' => $v['action_key'],
                'is_menu' => 0,
                'index' => 0,
            ];
        }

        $treeMenu = AdminService::tree($formatMenu);

        return $treeMenu;
    }


    public function systemAppMenu()
    {
        $menu = AdminService::appMenu();

        $treeMenu = AdminService::tree($menu);

        return $treeMenu;
    }

    /**
     * 系统节点
     */
    public function systemMenu()
    {
        $menu = AdminService::menu();

        $treeMenu = AdminService::tree($menu);

        return $treeMenu;
    }

    /**
     * 添加角色
     * @param       $companyId
     * @param       $name
     * @param array $menuIds
     * @throws ApiException
     */
    public function saveRole($name, $menuIds = [])
    {
        $masterRole = AuthRole::where(['is_master' => 1, 'is_del' => 0])->first();
        if (empty($masterRole)) {
            throw new ApiException('公司没有初始化角色');
        }
        $allMenu = AdminService::roleMenu([$masterRole->id]);
        $allMenuIds = array_column($allMenu, 'id');
        $webMenuIds = $menuIds['web'] ?? [];

        foreach ($webMenuIds as $k => $v) {
            if (!in_array($v, $allMenuIds)) {
                throw new ApiException('web菜单id选择错误');
            }
        }

        $roleId = AuthRole::insertGetId([
            'is_master' => 0,
            'name' => $name,
        ]);

        $roleMenu = [];
        foreach ($webMenuIds as $k => $v) {
            $roleMenu[] = [
                'role_id' => $roleId,
                'menu_id' => $v,
            ];
        }
        if (!empty($roleMenu)) {
            AuthRoleMenu::insert($roleMenu);
        }

        return $roleId;
    }

    /**
     * 编辑角色
     * @param       $roleId
     * @param       $name
     * @param array $menuIds
     * @throws ApiException
     */
    public function updateRole($roleId, $name, $menuIds)
    {
        $masterRole = AuthRole::where(['is_master' => 1, 'is_del' => 0])->first();
        if (empty($masterRole)) {
            throw new ApiException('公司没有初始化角色');
        }
        $allMenu = AdminService::roleMenu([$masterRole->id]);
        $allMenuIds = array_column($allMenu, 'id');

        $webMenuIds = $menuIds['web'] ?? [];
        $appMenuIds = $menuIds['app'] ?? [];
        $fundIds = $menuIds['data'] ?? [];
        foreach ($webMenuIds as $k => $v) {
            if (!in_array($v, $allMenuIds)) {
                throw new ApiException('菜单id选择错误');
            }
        }

        $roleInfo = AuthRole::where(['id' => $roleId, 'is_del' => 0])->first();
        if (empty($roleInfo)) {
            throw new ApiException('角色非法修改');
        }
        if ($roleInfo->is_master == 1) {
            throw new ApiException('初始化角色不能被修改');
        }

        $roleMenu = AuthRoleMenu::select('menu_id')->where(['role_id' => $roleId, 'is_del' => 0])->get()->toArray();
        $roleMenuIds = array_column($roleMenu, 'menu_id');

        $delRoleMenu = [];
        $addRoleMenu = [];
        // 删除的角色
        foreach ($roleMenuIds as $k => $v) {
            if (!in_array($v, $webMenuIds)) {
                $delRoleMenu[] = $v;
            }
        }

        //新增的角色
        foreach ($webMenuIds as $k => $v) {
            if (!in_array($v, $roleMenuIds)) {
                $addRoleMenu[] = [
                    'role_id' => $roleId,
                    'menu_id' => $v,
                ];
            }
        }

        AuthRole::where('id', $roleId)->update([
            'name' => $name
        ]);

        if (!empty($delRoleMenu)) {
            AuthRoleMenu::where('role_id', $roleId)->whereIn('menu_id', $delRoleMenu)->update([
                'is_del' => 1
            ]);
        }

        if (!empty($addRoleMenu)) {
            AuthRoleMenu::insert($addRoleMenu);
        }

        // 通知事件缓存
//        event(new SyncUserPermissionEvent($roleId, null));
    }

    /**
     * 角色删除
     * @param $companyId
     * @param $roleId
     * @throws ApiException
     */
    public function delRole($companyId, $roleId)
    {
        $roleInfo = AuthRole::where(['id' => $roleId, 'is_del' => 0])->first();
        if (empty($roleInfo)) {
            throw new ApiException('角色非法删除');
        }
        if ($roleInfo->is_master == 1) {
            throw new ApiException('初始化角色不能被删除');
        }

        $hasUser = AuthAdminUserRole::where(['role_id' => $roleId, 'is_del' => 0])->first();
        if (!empty($hasUser)) {
            throw new ApiException('该角色下存在用户，不能被删除');
        }

        AuthRole::where('id', $roleId)->update([
            'is_del' => 1
        ]);

    }

    /**
     * 给用户授权角色
     * @param int $companyId
     * @param int $userId
     * @param array $roles
     * @throws ApiException
     */
    public function authorizeRole(int $userId, array $roles)
    {
        $companyRoles = AdminService::listCompanyRole()->toArray();

        $userInfo = AdminUser::where(['id' => $userId, 'is_del' => 0])->first();
        if (empty($userInfo)) {
            throw new ApiException('该用户被删除或者不存在');
        }
        if ($userInfo->is_master == 1) {
            throw new ApiException('初始化用户不能被操作');
        }

        $companyRolesId = array_column($companyRoles, 'id');
        foreach ($roles as $k => $role) {
            if (!in_array($role, $companyRolesId)) {
                throw new ApiException("角色[{$role}]选择错误");
            }
        }

        // 用户已经存在角色
        $userRoles = AuthAdminUserRole::where(['admin_user_id' => $userId, 'is_del' => 0])->get()->toArray();
        $userRolesId = array_column($userRoles, 'role_id');


        $delRole = [];
        $addRole = [];
        // 删除的角色
        foreach ($userRolesId as $k => $v) {
            if (!in_array($v, $roles)) {
                $delRole[] = $v;
            }
        }

        //新增的角色
        foreach ($roles as $k => $v) {
            if (!in_array($v, $userRolesId)) {
                $addRole[] = [
                    'admin_user_id' => $userId,
                    'role_id' => $v,
                ];
            }
        }
        if (!empty($delRole)) {
            AuthAdminUserRole::where('admin_user_id', $userId)->whereIn('role_id', $delRole)->update([
                'is_del' => 1
            ]);
        }
        if (!empty($addRole)) {
            AuthAdminUserRole::insert($addRole);
        }
        // 更新用户redis缓存
//        event(new SyncUserPermissionEvent(null, $userId));
    }


}
