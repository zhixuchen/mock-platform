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
    protected $title = 'App\Models\MockCallback';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockCallback());

        $grid->column('id', __('Id'));
        $grid->column('project_id', __('Project id'));
        $grid->column('name', __('Name'));
        $grid->column('request_uri', __('Request uri'));
        $grid->column('request_body', __('Request body'));
        $grid->column('pragram', __('Pragram'));
        $grid->column('status', __('Status'));

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
        $show->field('project_id', __('Project id'));
        $show->field('name', __('Name'));
        $show->field('request_uri', __('Request uri'));
        $show->field('request_body', __('Request body'));
        $show->field('pragram', __('Pragram'));
        $show->field('status', __('Status'));

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

        $form->number('project_id', __('Project id'));
        $form->text('name', __('Name'));
        $form->text('request_uri', __('Request uri'));
        $form->textarea('request_body', __('Request body'));
        $form->text('pragram', __('Pragram'));
        $form->text('status', __('Status'));

        return $form;
    }
}
