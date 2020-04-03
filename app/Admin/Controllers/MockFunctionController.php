<?php

namespace App\Admin\Controllers;

use App\Models\MockFunction;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MockFunctionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mock自定义方法表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockFunction());

//        $grid->column('id', __('Id'));
        $grid->filter(function(Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->like('type', '类型');
            $filter->like('function_name', '方法名');
        });
        $grid->column('type','类型');
        $grid->column('function_name', '方法名');
        $grid->column('value', '执行代码');

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
        $show = new Show(MockFunction::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', '类型');
        $show->field('function_name', '方法名');
        $show->field('value','执行代码');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MockFunction());

        $form->text('type', '类型');
        $form->text('function_name', '方法名');
        $form->textarea('value', '执行代码');

        return $form;
    }
}
