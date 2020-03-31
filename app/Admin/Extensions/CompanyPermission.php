<?php


namespace App\Admin\Extensions;


use App\Admin\Models\AppMenu;
use App\Admin\Models\AppRoleMenu;
use App\Admin\Models\AuthMenu;
use App\Admin\Models\AuthRole;
use App\Admin\Models\AuthRoleMenu;
use Encore\Admin\Form\Field;

class CompanyPermission extends Field
{
    protected $view = 'admin.companyPermission';

    protected static $css = [
    ];

    protected static $js = [
    ];


    public function render()
    {
        $this->permission();
        return parent::render();
    }

    public function permission()
    {
        $menu       = $this->systemMenu();
        $masterRole = AuthRole::where(['is_master' => 1, 'is_del' => 0])->first();
        $ids        = [];
        if ($masterRole) {
            $ids = AuthRoleMenu::where('role_id', $masterRole->id)->where('is_del', 0)->get()->toArray();
            $ids = array_values(array_unique(array_column($ids, 'menu_id')));
        }

        $this->addVariables([
            'menu'              => $menu,
            'companyMenuIds'    => $ids,
            'appMenu'           => [],
            'appCompanyMenuIds' => [],
        ]);
    }

    public function systemMenu()
    {
        $menu     = $this->menu();
        $treeMenu = self::tree($menu);
        return $treeMenu;
    }


    public function systemAppMenu()
    {
        $menu     = $this->appMenu();
        $treeMenu = self::tree($menu);

        return $treeMenu;
    }

    public function appMenu()
    {
        return AppMenu::select('id', 'pid', 'service_name as title', 'action_key as name')
            ->where([
                'status' => 1,
            ])
            ->get()->toArray();
    }

    /**
     * 获取菜单节点
     * @return array
     */
    public function menu()
    {
        return AuthMenu::select('id', 'pid', 'title', 'action_key as name', 'is_menu', 'child_action_id as index')
            ->where([
                'status' => 1,
            ])
            ->get()->toArray();
    }

    public static function tree($list, $name = 'children', $pid = 0)
    {
        $arr = [];
        foreach ($list as $k => $v) {
            if ($v['pid'] == $pid) {
                $v[$name] = self::tree($list, $name, $v['id']);
                $arr[]    = $v;
            }
        }

        return $arr;
    }


    public static function clientEncodePwd($pwd)
    {
        return md5($pwd);
    }

    public static function userPwdEncode($pwd)
    {
        $r = password_hash($pwd, PASSWORD_DEFAULT);
        return $r;
    }

}

