<?php

namespace App\Models;

use App\Helper\Util;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{

    const UPDATED_AT = null;
    protected $primaryKey = "id";
    protected $table = "admin_user";
    public $timestamps = false;
    const SUPER_ADMIN = 1;

    /**
     * hset key value
     */
    const USER_INFO_KEY = 'user_info_%s';
    // permission key
    const USER_INFO_PERMISSION = 'permission';

    /**
     * 获取redis key
     * @param $uid
     * @return string
     */
    public static function getUserCacheKey($uid)
    {
        return sprintf(self::USER_INFO_KEY, $uid);
    }


    //是超管不
    public function isMaster()
    {
        return $this->is_master == self::SUPER_ADMIN;
    }


    public static function pwdEncrypt($pwd)
    {
        return md5($pwd);
    }


    public function listWhere(Builder $builder, $params)
    {
        $name = $params['name'] ?? '';
        $mobile = $params['mobile'] ?? '';
        $roleId = $params['role_id'] ?? '';

        $builder->where('is_master', 0);
        if ($name != '') {
            $builder->where('name', 'like', "%{$name}%");
        }
        if ($mobile != '') {
            $builder->where('mobile', 'like', "%{$mobile}%");
        }
        if ($roleId) {
            $builder->whereHas('roles', function (Builder $query) use ($roleId) {
                $query->where('auth_admin_user_role.role_id', $roleId);
            });
        }

        return $builder;
    }

    /**
     * 关联角色
     */
    public function roles()
    {
        return $this->belongsToMany(AuthRole::class,
            'auth_admin_user_role',
            'admin_user_id',
            'role_id')
            ->select('auth_role.id', 'auth_role.name')
            ->where([
                'auth_admin_user_role.is_del' => 0,
                'auth_role.is_del' => 0,
            ]);
    }


    /**
     * 获取管理员分页
     * @param $page
     * @param $size
     * @param $params
     * @return array
     */
    public function list($page, $size, $params)
    {
        $fields = [
            'id',
            'name',
            'mobile',
            'is_active',
            'created_at',
        ];

        $countBuild = self::from($this->table);
        $countBuild = $this->listWhere($countBuild, $params);
        $total = $countBuild->count('id');

        $size = $size > 50 ? 50 : $size;
        $offset = ($page - 1) * $size;

        $list = [];
        if ($total) {
            $build = self::from($this->table)
                ->select($fields);
            $build = $this->listWhere($build, $params);
            $build->orderBy('id', 'desc');
            $list = $build->with([
                'roles',
            ])->offset($offset)->limit($size)->get();
        }

        return [
            'total' => $total,
            'list' => $list
        ];
    }


    /**
     * @param $pwd
     * @return bool
     */
    public function editPwd($pwd)
    {
        $this->password = Util::userPwdEncode($pwd);
        $r = $this->save();
        $this->expireMyToken();
        return $r;
    }

    public function expireMyToken()
    {
        AuthAdminToken::where('admin_user_id', $this->id)
            ->where('status', '!=', AuthAdminToken::TOKEN_EXPIRED)
            ->update([
                'status'=>AuthAdminToken::TOKEN_EXPIRED
            ]);
    }

}
