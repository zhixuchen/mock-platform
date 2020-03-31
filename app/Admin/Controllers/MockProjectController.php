<?php

namespace App\Admin\Controllers;

use App\Models\MockProject;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MockProjectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MockProject());

        $grid->filter(function(Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->like('project', '项目名称');
        });

        $grid->column('id', 'id');
        $grid->column('project', '项目');
        $grid->column('name', '名称');
        $grid->column('rule', '规则');

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
        $show = new Show(MockProject::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('project', __('Project'));
        $show->field('name', __('Name'));
        $show->field('rule', __('Rule'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MockProject());

        $form->text('project', __('Project'));
        $form->text('name', __('Name'));
        $form->text('rule', __('Rule'));

        return $form;
    }
}
