<?php

namespace App\Admin\Controllers;

use App\Models\MockCallback;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MockCallbackController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mock回调管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockCallback());

        $grid->column('id', __('Id'));
        $grid->column('project_id', '项目id');
        $grid->column('name', '名称');
        $grid->column('request_uri', '回调接口地址');
        $grid->column('request_body', '请求BODY')->hide();
        $grid->column('pragram', '传参');
        $grid->column('status', '状态');

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
        $show = new Show(MockCallback::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('project_id','项目id');
        $show->field('name', '名称');
        $show->field('request_uri','回调接口地址');
        $show->field('request_body', '请求BODY');
        $show->field('pragram', '传参');
        $show->field('status', '状态');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MockCallback());

        $form->number('project_id', '项目id');
        $form->text('name', '名称');
        $form->text('request_uri','回调接口地址');
        $form->textarea('request_body','请求BODY');
        $form->text('pragram', '传参');
        $form->text('status', '状态');

        return $form;
    }
}
