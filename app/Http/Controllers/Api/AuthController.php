<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Region;
use App\Services\AdminService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // 登录
    public function login(Request $request, AdminService $adminService)
    {
        $this->validate($request, [
            'type' => 'required|in:1,2',
            'account' => 'required',
            'password' => 'required'
        ]);
        $type = $request->input('type');
        $account = $request->input('account');
        $password = $request->input('password');

        $res = [];
        if ($type == 1) {
            $res = $adminService->accountLogin($account, $password);
        } elseif ($type == 2) {
            $res = $adminService->codeLogin($account, $password);
        }
        return $this->success($res);
    }

    // 修改密码
    public function updatePasswd(Request $request)
    {
        $oldPwd = $request->input('old_pwd');
        $password = $request->input('password');

        $r = AdminService::editPwd(Auth::user(), $oldPwd, $password);
        return $this->success($r);
    }

    /**
     * web端获取权限菜单
     */
    public function menu(AdminService $adminService)
    {
        $res = $adminService::getUserMenu(Auth::id());
        return $this->success($res);
    }

    // 获取管理员列表
    public function listAdmin(Request $request)
    {
        $this->validate($request, [
            'page' => 'int',
            'size' => 'int'
        ]);
        $page = $request->input('page', 1);
        $size = $request->input('size', 20);
        $list = (new AdminUser())->list(
            $page,
            $size,
            $request->input()
        );
        return $this->success($list);
    }

    // 添加管理员
    public function saveAdmin(Request $request, PermissionService $permissionService)
    {
        $requestData = $request->input();

        $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            "password" => "required",
            "password_confirm" => "required|same:password",
            "city_code" => "required",
            "role_ids" => 'array',
            'data_power' => 'array',
            'idcard' => 'required|min:18|max:18|string',
        ]);


        // 临时解决，多商户登录
        $theCompanyUser = AdminUser::select('id')->where([
            'mobile' => $request->input('mobile'),
            'is_del' => 0,
        ])->first();

        // 允许多商户登录
        if ($theCompanyUser) {
            throw new ApiException('手机号已经存在');
        }

        $city = Region::where('code', $requestData['city_code'])->first();
        if (empty($city)) {
            throw new ApiException('所选择的市错误');
        }
        $privince = Region::where('code', $city->parent_code)->first();
        if (empty($privince)) {
            throw new ApiException('省份错误');
        }

        $groupIds = $request->input('group_ids');
        $authOrganizeId = is_array($groupIds) ? intval(end($groupIds)) : 0;

        //用户密码
        $password = $request->input('password');
        $encdPassword = empty($otherCompanyUser) ?
            Util::userPwdEncode(Util::clientEncodePwd($password))
            : $otherCompanyUser->password;

        $userId = AdminUser::insertGetId([
            'name' => $requestData['name'],
            'mobile' => $requestData['mobile'],
            'password' => $encdPassword,
            'created_admin_user_id' => Auth::id(),
            'created_admin_user' => Auth::user()->name,
            'province_code' => $privince->code,
            'city_code' => $city->code,
            'province_name' => $privince->name,
            'city_name' => $city->name,
            'auth_organize_id' => $authOrganizeId,
            'idcard' => $requestData['idcard'],
        ]);

        $roleids = $request->input('role_ids');
        if (!empty($roleids)) {
            $permissionService->authorizeRole(
                $userId,
                $roleids
            );
        }

        return $this->success(true);
    }

    // 更新用户信息
    public function updateAdmin(Request $request, PermissionService $permissionService)
    {
        $requestData = $request->input();
        $this->validate($request, [
            "id" => "required|int",
//            "name"      => "required",
//            "city_code" => "required",
        ]);
        $updateData = [];
        $hasMobile = AdminUser::select('id', 'is_master')->where([
            'id' => $requestData['id'],
            'is_del' => 0,
        ])->first();
        if (!$hasMobile) {
            throw new ApiException('账号不存在');
        }
        if ($hasMobile->is_master == 1) {
            throw new ApiException('公司初始化账号不能修改');
        }
        if ($request->has('city_code')) {
            // 检测privince_code,city_code
            $city = Region::where('code', $requestData['city_code'])->first();
            if (empty($city)) {
                throw new ApiException('所选择的市错误');
            }
            $privince = Region::where('code', $city->parent_code)->first();
            if (empty($privince)) {
                throw new ApiException('省份错误');
            }
            $updateData['province_code'] = $privince->code;
            $updateData['city_code'] = $city->code;
            $updateData['province_name'] = $privince->name;
            $updateData['city_name'] = $city->name;
        }


        if ($request->has('name')) {
            $updateData['name'] = $request->input('name');
        }
        if ($request->has('idcard')) {
            $updateData['idcard'] = $request->input('idcard');
        }



        if (!empty($updateData)) {
            AdminUser::where([
                'id' => $requestData['id'],
            ])->update($updateData);
        }

        $roleids = $request->input('role_ids');
        if (!empty($roleids)) {
            $permissionService->authorizeRole(
                $requestData['id'],
                $roleids
            );
        }

        return $this->success(true);
    }

    // 管理员详情
    public function infoAdmin(Request $request)
    {
        $id = $request->input('id');
        $fields = [
            'id',
            'name',
            'mobile',
            'entry_time',
            'city_code',
            'province_name',
            'province_code',
            'city_name',
            'auth_organize_id',
            'data_permission',
            'idcard',
        ];
        $userInfo = AdminUser::select($fields)
            ->where([
                'id' => $id,
            ])
            ->first();
        if (!$userInfo) {
            throw new ApiException('用户不存在');
        }

        $role = AdminService::userRole($id);
        return $this->success([
            'id' => $userInfo->id,
            'name' => $userInfo->name,
            'role_ids' => array_values(array_unique(array_column($role, 'role_id'))),
            'mobile' => $userInfo->mobile,
            'province_code' => $userInfo->province_code,
            'city_code' => $userInfo->city_code,
            'area' => $userInfo->province_name . $userInfo->city_name,
            'data_power' => $userInfo->data_permission,
            'idcard' => $userInfo->idcard
        ]);
    }

    // 获取公司角色并且带数量
    public function listCompanyRole(AdminService $adminService)
    {
        $role = $adminService::listCompanyRoleWithUserNum();
        return $this->success($role);
    }

    /**
     *  启用/禁用账户[is_active:1启用，0：禁用]
     */
    public function updateAdminActive(Request $request)
    {
        $this->validate($request, [
            "id" => "required",
            "is_active" => "required|in:0,1",
        ]);

        $id = $request->input('id');
        $isActive = $request->input('is_active');
        if ($id == Auth::id()) {
            throw new ApiException('当前登录账号不能操作');
        }

        $userInfo = AdminUser::select('id', 'is_active', 'is_master')->where([
            'id' => $id,
            'is_del' => 0,
        ])->first();

        if (!$userInfo) {
            throw new ApiException('账号不存在');
        }
        if ($userInfo->is_master == 1) {
            throw new ApiException('公司初始化账号不能被操作');
        }
        AdminUser::where([
            'id' => $id,
        ])->update([
            'is_active' => $isActive
        ]);
        return self::out(true);
    }


}
