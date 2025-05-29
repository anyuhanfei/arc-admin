<?php
namespace App\Admin\Controllers;

use App\Repositories\AppVersions;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AppVersionsController extends AdminController{
    protected function grid(){
        return Grid::make(new AppVersions(), function (Grid $grid){
            $grid->model()->orderBy("version", "desc");
            $grid->column('version');
            $grid->column('version_name');
            $grid->column('is_force')->switch();
            $grid->column('is_complete')->switch();
            $grid->column('size');
            $grid->column('content');
            $grid->column('created_at');
            $grid->disableViewButton();
            $grid->disableRowSelector();
        });
    }

    protected function detail($id){
        return Show::make($id, new AppVersions(), function (Show $show) {
            $show->field('id');
            $show->field('is_force');
            $show->field('wgt_url');
            $show->field('i_app_url');
            $show->field('a_app_url');
            $show->field('is_complete');
            $show->field('version');
            $show->field('version_name');
            $show->field('size');
            $show->field('content');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new AppVersions(), function (Form $form) {
            $form->display('id');
            admin_form_image_field($form->file('wgt_url', "增量更新文件")->maxSize(100000)->required());
            $form->hidden('i_app_url');
            admin_form_image_field($form->file('a_app_url', '安卓安装包')->maxSize(100000));
            $form->switch('is_force')->required();
            $form->switch('is_complete');
            $form->text('version')->required();
            $form->text('version_name')->required();
            $form->text('size')->required();
            $form->textarea('content')->required();
            $form->display('created_at');
            $form->display('updated_at');
            $form->disableViewButton();
            $form->disableViewCheck();
        });
    }
}