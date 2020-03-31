<?php

namespace App\Admin\Controllers;

use App\Admin\Models\AuthPermission;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Redis;

class AuthPermissionController extends Controller
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
            ->header('路由管理')
            ->description('列表')
            ->body($this->grid());
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
            ->header('编辑')
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
        $grid = new Grid(new AuthPermission);
        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('name', '标题');
            $filter->like('http_path', '路径');
        });
        $grid->model()->where('is_del', 0);

        $grid->id('Id');
        $grid->name('标题');
//        $grid->http_method('Http method');
        $grid->http_path('路径');
        $grid->params('参数');
        $grid->rank('排序');
        $grid->is_check('是否需要检测权限')->using([
            1 => '是',
            0 => '否'
        ]);
        $grid->created_at('添加时间');
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
        $show = new Show(AuthPermission::findOrFail($id));

        $show->id('Id');
        $show->pid('Pid');
        $show->is_menu('Is menu');
        $show->code('Code');
        $show->menu_name('Menu name');
        $show->name('Name');
        $show->http_method('Http method');
        $show->http_path('Http path');
        $show->params('Params');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->rank('Rank');
        $show->is_del('Is del');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AuthPermission);

        $form->text('name', '标题');
        $form->text('http_path', '路径');
        $form->textarea('params', '参数')->help('json格式');
        $form->switch('is_check', '是否检测权限')->states([
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
        ])->default(1)->help('否：表示该接口无线检测权限');
        $form->switch('rank', '排序')->default(1000);
        $form->saved(function ($form) {
//            Redis::select(0);
//            Redis::del(Redis::keys('user_info_*'));
        });

        return $form;
    }
}
