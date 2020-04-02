<?php

namespace App\Admin\Controllers;

use App\Models\MockProjectMethod;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MockProjectMethodController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mock请求方法管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new MockProjectMethod());
        $grid->filter(function(Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->like('project_id', '项目id');
            $filter->like('name', '方法名称');
            $filter->like('uri', '接口地址');
            $filter->like('pragram', '可变参数');
        });
        $grid->column('id', __('Id'));
        $grid->column('project_id','项目id');
        $grid->column('name', '方法名称');
        $grid->column('uri', '接口地址');
        $grid->column('route', '路由');
        $grid->column('type', 'mock类型（默认1）');
        $grid->column('result', 'mock返回结果')->hide();
        $grid->column('pragram', '可变参数');


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
        $show = new Show(MockProjectMethod::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('project_id','项目id');
        $show->field('name', '方法名称');
        $show->field('uri','接口地址');
        $show->field('route', '路由');
        $show->field('type','mock类型（默认1）');
        $show->field('result', 'mock返回结果');
        $show->field('pragram', '可变参数');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MockProjectMethod());

        $form->number('project_id','项目id');
        $form->text('name', '方法名称');
        $form->text('uri', '接口地址');
        $form->text('route', '路由');
        $form->number('type', 'mock类型（默认1）')->default(1);
        $form->textarea('result','mock返回结果');
        $form->text('pragram', '可变参数');

        return $form;
    }
}
