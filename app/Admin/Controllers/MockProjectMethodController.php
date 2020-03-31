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

        $grid->column('id', __('Id'));
        $grid->column('project_id', __('Project id'));
        $grid->column('name', __('Name'));
        $grid->column('uri', __('Uri'));
        $grid->column('route', __('Route'));
        $grid->column('type', __('Type'));
        $grid->column('result', __('Result'));
        $grid->column('pragram', __('Pragram'));

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
        $show->field('project_id', __('Project id'));
        $show->field('name', __('Name'));
        $show->field('uri', __('Uri'));
        $show->field('route', __('Route'));
        $show->field('type', __('Type'));
        $show->field('result', __('Result'));
        $show->field('pragram', __('Pragram'));

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
