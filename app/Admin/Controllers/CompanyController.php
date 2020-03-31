<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CompanyPermission;
use App\Admin\Models\AdminUser;
use App\Admin\Models\AppRoleMenu;
use App\Admin\Models\AuthAdminUserRole;
use App\Admin\Models\AuthMenu;
use App\Admin\Models\AuthRole;
use App\Admin\Models\AuthRoleMenu;
use App\Admin\Models\Company;
use App\Admin\Models\CompanyProcess;
use App\Admin\Models\Process;
use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use App\Models\CreditLog;
use App\Models\ECompanyInfo;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\MessageBag;

class CompanyController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('公司管理')
            ->description('列表')
            ->body($this->grid());
    }



    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('description')
            ->body($this->form($id)->edit($id));
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = 0)
    {

        Form::extend('companyPermission', CompanyPermission::class);
        $form = new Form(new AuthMenu());


        $form->disableCreatingCheck()->disableEditingCheck()->disableViewCheck();
        $form->tools(function (Form\Tools $form) {
            $form->disableDelete()->disableList()->disableView();
        });

        $form->saving(function (Form $form) {
            DB::beginTransaction();
//            return $this->checkForm();
        });

        $form->saved(function (Form $form) {
            $this->saveCompany($form);
//            Redis::select(0);
//            Redis::del(Redis::keys('user_info_*'));
            DB::commit();

            return redirect(admin_base_path('company/1/edit'));
        });
        $form->companyPermission('model', '公司id');

        $form->ignore(['master_account', 'model', 'master_user_id', 'password', 'company_info','company_process','e_company_info']);
        return $form;
    }

    private function saveCompany(Form $form)
    {
        $request   = request();
        $masterUser = AdminUser::where('is_master', 1)->first();
        $masterRole   = AuthRole::where(['is_master' => 1])->first();
        // 判断账号是否存在
        $password   = $request->input('password', '123456');
        $enPassword = CompanyPermission::userPwdEncode(CompanyPermission::clientEncodePwd($password));

        if (empty($masterUser)) {
            $adminMasterUser = [
                'name'            => '超级管理员',
                'mobile'          => $request->input('master_account', ''),
                'password'        => $enPassword,
                'is_master'       => 1,
                'data_permission' => 4,
            ];
            $masterUserId    = AdminUser::insertGetId($adminMasterUser);
        } else {
            $masterUserId = $masterUser->id;
            // 更新密码
            if (!empty($request->input('password'))) {
                AdminUser::where('id', $masterUserId)->update([
                    'password' => $enPassword,
                ]);
            }
        }
        // 角色
        if (empty($masterRole)) {
            $masterRoleId = AuthRole::insertGetId([
                'is_master'  => 1,
                'name'       => '初始化角色',
            ]);
        } else {
            $masterRoleId = $masterRole->id;
        }

        // 给用户赋予权限
        $hasRole = AuthAdminUserRole::where('role_id', $masterRoleId)->first();
        if (empty($hasRole)) {
            AuthAdminUserRole::insert([
                'admin_user_id' => $masterUserId,
                'role_id'       => $masterRoleId
            ]);
        }

        // 菜单权限
        $roleMenu    = AuthRoleMenu::select('menu_id')->where(['role_id' => $masterRoleId, 'is_del' => 0])->get()->toArray();
        $roleMenuIds = array_column($roleMenu, 'menu_id');

        $delRoleMenu = [];
        $addRoleMenu = [];
        $menuIds     = $request->input('menu_id', []);
        // 删除的菜单
        foreach ($roleMenuIds as $k => $v) {
            if (!in_array($v, $menuIds)) {
                $delRoleMenu[] = $v;
            }
        }

        //新增的角色
        foreach ($menuIds as $k => $v) {
            if (!in_array($v, $roleMenuIds)) {
                $addRoleMenu[] = [
                    'role_id' => $masterRoleId,
                    'menu_id' => $v,
                ];
            }
        }

        if (!empty($delRoleMenu)) {
            AuthRoleMenu::where('role_id', $masterRoleId)->whereIn('menu_id', $delRoleMenu)->update([
                'is_del' => 1
            ]);
        }
        if (!empty($addRoleMenu)) {
            AuthRoleMenu::insert($addRoleMenu);
        }

    }
}
