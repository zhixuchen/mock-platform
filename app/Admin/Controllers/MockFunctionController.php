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
    protected $title = 'App\Models\MockFunction';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockFunction());

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('function_name', __('Function name'));
        $grid->column('value', __('Value'));

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
        $show->field('type', __('Type'));
        $show->field('function_name', __('Function name'));
        $show->field('value', __('Value'));

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

        $form->text('type', __('Type'));
        $form->text('function_name', __('Function name'));
        $form->textarea('value', __('Value'));

        return $form;
    }
}
