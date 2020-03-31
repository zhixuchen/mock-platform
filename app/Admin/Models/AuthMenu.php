<?php


namespace App\Admin\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

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
class AuthMenu extends Model
{
    use ModelTree, AdminBuilder;

    protected $table      = 'auth_menu';
    protected $primaryKey = 'id';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('rank');
        $this->setTitleColumn('title');
    }

    public function permissions()
    {
        return $this->belongsToMany(AuthPermission::class, 'auth_menu_permission', 'menu_id', 'permission_id');
    }


}