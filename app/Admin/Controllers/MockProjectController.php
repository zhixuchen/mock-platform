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
        $show->field('project','项目');
        $show->field('name', '名称');
        $show->field('rule', '规则');


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

        $form->text('project','项目');
        $form->text('name','名称');
        $form->text('rule','规则');

        return $form;
    }
}
