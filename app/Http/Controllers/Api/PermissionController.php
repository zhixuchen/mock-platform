<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\AuthRole;
use App\Models\AuthRoleMenu;
use App\Services\AdminService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * 公司角色权限节点
     * @throws ApiException
     */
    public function rolePermission(PermissionService $permissionService)
    {
        $webTreeMenu = $permissionService->companyMasterRolePermission();

        return $this->success([
            'web' => $webTreeMenu,
        ]);
    }

    // 获取角色菜单id
    public function roleMenuId(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required'
        ]);
        $roleId = $request->input('role_id');

        $roleInfo = AuthRole::where([
            'id' => $roleId,
            'is_del' => 0,
        ])->first();
        if (empty($roleInfo)) {
            throw new ApiException('该角色不存在或无权访问');
        }

        $ids = AuthRoleMenu::where('role_id', $roleId)->where('is_del', 0)->get()->toArray();
        $webRightIds = array_values(array_unique(array_column($ids, 'menu_id')));


        // 获取master角色权限
        $masterRole = AuthRole::where([
            'is_del' => 0,
            'is_master' => 1
        ])->first();
        if (empty($masterRole)) {
            $webRightIds = [];
        } else {
            $masterRoleMenu = AdminService::roleMenu([$masterRole->id]);
            $masterRoleMenuIds = array_column($masterRoleMenu, 'id');

            $returnMenu = [];
            foreach ($webRightIds as $k => $v) {
                if (in_array($v, $masterRoleMenuIds)) {
                    $returnMenu[] = $v;
                }
            }
            $webRightIds = $returnMenu;
        }




        return self::out([
            'name' => $roleInfo->name,
            'right_ids' => [
                'web' => $webRightIds,
//                'app' => $appRightIds,
//                'data' => $fundIds,
            ],
        ]);

    }

    // 添加角色
    public function saveRole(Request $request, PermissionService $permissionService)
    {
        $this->validate($request, [
            'name' => 'required',
            'right_ids.web' => 'array',
            'right_ids.app' => 'array',
        ]);

        $roleId = $permissionService->saveRole(
            $request->input('name'),
            $request->input('right_ids', ['web' => [], 'app' => [], 'data' => []])
        );

        return $this->success($roleId);

    }

    // 修改角色
    public function updateRole(Request $request, PermissionService $permissionService)
    {
        $this->validate($request, [
            'name' => 'required',
            'right_ids.web' => 'array',
            'right_ids.app' => 'array',
            'role_id' => 'required|numeric',
        ]);
        $permissionService->updateRole(
            $request->input('role_id'),
            $request->input('name'),
            $request->input('right_ids', ['web' => [], 'app' => [], 'data' => []])
        );

        return $this->success(true);

    }

    // 删除角色
    public function delRole(Request $request, PermissionService $permissionService)
    {
        $this->validate($request, [
            'role_id' => 'required|numeric',
        ]);
        $permissionService->delRole(
            Auth::user()->company_id,
            $request->input('role_id')
        );

        return self::out(true);
    }


    // 给用户授权角色
    public function authorizeRole(PermissionService $permissionService)
    {
        $this->validate($this->request, [
            'id' => 'required|numeric',
            'roles' => 'required|array',
        ]);

        $permissionService->authorizeRole(
            Auth::user()->company_id,
            $this->request->input('id'),
            $this->request->input('roles')
        );

        return self::out(true);
    }

}
