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
    protected $title = 'App\Models\MockProjectMethod';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockProjectMethod());

        $grid->column('id', __('Id'))->width(50);
        $grid->column('project_id','项目id')->width(70);
        $grid->column('name', '项目名称')->width(200);
        $grid->column('uri', '接口地址')->width(200);
        $grid->column('route', '路由')->width(100);
        $grid->column('type', 'mock类型（默认1）')->width(200);
        $grid->column('result', 'mock返回结果')->hide()->width(200);
        $grid->column('pragram', '可变参数')->width(100);


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
        $show->field('name', '项目名称');
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

        $form->number('project_id', __('Project id'));
        $form->text('name', __('Name'));
        $form->text('uri', __('Uri'));
        $form->text('route', __('Route'));
        $form->number('type', __('Type'))->default(1);
        $form->textarea('result', __('Result'));
        $form->text('pragram', __('Pragram'));

        return $form;
    }
}
