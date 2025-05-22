<?php

namespace App\Admin\Controllers\Faq;

use App\Repositories\Faq\Faqs;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FaqsController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Faqs(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type');
            $grid->column('question');
            $grid->column('answer');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
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
        return Show::make($id, new Faqs(), function (Show $show) {
            $show->field('id');
            $show->field('type');
            $show->field('question');
            $show->field('answer');
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
        return Form::make(new Faqs(), function (Form $form) {
            $form->display('id');
            $form->text('type');
            $form->text('question');
            $form->text('answer');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
