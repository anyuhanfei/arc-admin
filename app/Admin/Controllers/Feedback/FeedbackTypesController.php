<?php

namespace App\Admin\Controllers\Feedback;

use App\Repositories\Feedback\FeedbackTypes;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FeedbackTypesController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new FeedbackTypes(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('sort')->orderable();
            // $grid->column('created_at');
            // $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
            });
            $grid->disableViewButton();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new FeedbackTypes(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('sort');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new FeedbackTypes(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            // $form->text('sort');
            // $form->display('created_at');
            // $form->display('updated_at');

            $form->saved(function(Form $form){
                // 排序字段自动改为id
                if($form->isCreating()){
                    $form->sort = $form->model()->id;
                }
            });
            $form->disableViewButton();
            $form->disableViewCheck();
        });
    }
}
