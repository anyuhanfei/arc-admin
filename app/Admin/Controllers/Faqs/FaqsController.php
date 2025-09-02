<?php

namespace App\Admin\Controllers\Faqs;

use App\Enums\StatusEnum;
use App\Repositories\Faqs\Faqs;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

// 常见问题
class FaqsController extends AdminController{
    protected function grid(){
        return Grid::make(new Faqs(['type']), function (Grid $grid){
            $grid->model()->orderBy("id", 'desc');
            $grid->column('id')->sortable();
            $grid->column('type.name', '类型')->width("10%");
            $grid->column('question')->width("20%");
            $grid->column('answer')->width("35%");
            $grid->column('status', '状态')->using(StatusEnum::getDescriptions())->dot(StatusEnum::getColors());
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like("question");
                $filter->equal("type")->select("get/faqs/types");
            });
            $grid->disableViewButton();
        });
    }

    protected function detail($id){
        return Show::make($id, new Faqs(), function (Show $show) {
            $show->field('id');
            $show->field('type_id');
            $show->field('question');
            $show->field('answer');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new Faqs(), function (Form $form) {
            $form->display('id');
            $form->select('type_id', '选择类型')->options("get/faqs/types")->required();
            $form->text('question')->required();
            $form->textarea('answer')->required();
            $form->radio('status', '状态')->options(StatusEnum::getDescriptions())->help("当选择隐藏时，是对用户隐藏。")->default(StatusEnum::NORMAL)->required();
            $form->disableViewButton();
            $form->disableViewCheck();
        });
    }
}
