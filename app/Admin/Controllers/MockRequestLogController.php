<?php

namespace App\Admin\Controllers;

use App\Models\MockRequestLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MockRequestLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mock请求日志管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockRequestLog());
        $grid->filter(function(Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->like('project_id', '项目id');
            $filter->like('type', '请求类型');
            $filter->like('method_id', '请求关联id');
            $filter->like('request_url', '请求URL');
            $filter->like('request_method', '请求方式');
        });
        $grid->column('id', __('Id'));
        $grid->column('type', '请求类型');
        $grid->column('method_id', '请求关联id');
        $grid->column('name', '请求名称');
        $grid->column('request_url', '请求URL');
        $grid->column('request_body', '请求BODY')->hide();
        $grid->column('request_method', '请求方式');
        $grid->column('response', '响应')->hide();
        $grid->column('creat_time', '创建时间');

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
        $show = new Show(MockRequestLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', '请求类型');
        $show->field('method_id', '请求关联id');
        $show->field('name', '请求名称');
        $show->field('request_url', '请求URL');
        $show->field('request_body','请求BODY');
        $show->field('request_method', '请求方式');
        $show->field('response', '响应');
        $show->field('creat_time', '创建时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MockRequestLog());
        $form->text('type', '请求类型');
        $form->number('method_id', '请求关联id');
        $form->text('name', '请求名称');
        $form->text('request_url', '请求URL');
        $form->textarea('request_body', '请求BODY');
        $form->text('request_method', '请求方式');
        $form->textarea('response','响应');
        $form->datetime('creat_time', '创建时间')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
