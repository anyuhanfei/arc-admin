<?php

namespace App\Admin\Controllers\Faqs;

use App\Enums\StatusEnum;
use App\Repositories\Faqs\FaqTypes;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 常见问题类型
class FaqTypesController extends AdminController{
    protected function grid(){
        return Grid::make(new FaqTypes(), function (Grid $grid){
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('status')->using(StatusEnum::getDescriptions())->dot(StatusEnum::getColors());
            $grid->disableViewButton();
        });
    }

    protected function detail($id){
        return Show::make($id, new FaqTypes(), function (Show $show){
            $show->field('id');
            $show->field('name');
            $show->field('status')->using(StatusEnum::getDescriptions())->dot(StatusEnum::getColors());
            // $show->field('created_at');
            // $show->field('updated_at');
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(){
        return Form::make(new FaqTypes(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->radio('status')->options(StatusEnum::getDescriptions())->help("当选择隐藏时，是对会员隐藏。")->default(StatusEnum::NORMAL);
            $form->disableViewButton();
            $form->disableViewCheck();
        //     $form->saving(function (Form $form){
        //         DB::beginTransaction();
        //     });
        //     $form->saved(function (Form $form){
        //         if($form->isDeleting()){
        //             // 删除类型时，将该类型下的所有问题删除
        //         }
        //         DB::commit();
        //     });
        });
    }

    public function get_types(Request $request){
        $name = $request->get('q');
        return (new FaqTypes())->admin_get_datas_by_name($name);
    }
}
