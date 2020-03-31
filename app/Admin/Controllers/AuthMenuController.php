<?php

namespace App\Admin\Controllers;

use App\Admin\Models\AuthMenu;
use App\Admin\Models\AuthPermission;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;

class AuthMenuController extends Controller
{
    use HasResourceActions;

    protected function treeView()
    {

        return AuthMenu::tree(function (Tree $tree) {
            $tree->query(function ($model) {
                return $model->orderBy('rank', 'asc')->orderBy('id', 'asc');
            });
        });
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('')
            ->description('')
            ->row(function (Row $row) {
                $row->column(12, $this->treeView()->render());
            });
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
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
            ->header('便捷')
            ->description('')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('添加')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AuthMenu);

        $grid->id('Id');
        $grid->pid('Pid');
        $grid->child_action_id('Child action id');
        $grid->title('Title');
        $grid->icon('Icon');
        $grid->action_key('Action key');
        $grid->is_menu('Is menu');
        $grid->rank('Rank');
        $grid->status('Status');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->icon_url('Icon url');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(AuthMenu::findOrFail($id));

        $show->id('Id');
        $show->pid('Pid');
        $show->child_action_id('Child action id');
        $show->title('Title');
        $show->icon('Icon');
        $show->action_key('Action key');
        $show->is_menu('Is menu');
        $show->rank('Rank');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->icon_url('Icon url');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AuthMenu);

        $form->number('child_action_id', '子级跳转id')->default(0);
        $form->text('title', '标题');
        $form->text('icon', 'Icon');
        $form->text('action_key', '前端key');
//        $states = [
//            'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
//            'off' => ['value' => '0', 'text' => '否', 'color' => 'danger'],
//        ];
        $form->select('is_menu', '是否是菜单')->options([
            1 => '是',
            0 => '否'
        ]);
        $form->number('rank', '排序')->default(1000);
        $form->switch('status', '状态')->states([
            'on'  => ['value' => '1', 'text' => '开启', 'color' => 'primary'],
            'off' => ['value' => '0', 'text' => '禁用', 'color' => 'danger'],
        ])->default(1);
        $form->listbox('permissions', '权限')
            ->options(AuthPermission::select('id', DB::raw("concat('【',name,'】', http_path) as title"))->where(['is_del' => 0])->get()->pluck('title', 'id'));

        return $form;
    }
}
