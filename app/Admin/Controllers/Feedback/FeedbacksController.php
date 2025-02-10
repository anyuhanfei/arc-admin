<?php

namespace App\Admin\Controllers\Feedback;

use App\Repositories\Feedback\Feedbacks;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FeedbacksController extends AdminController{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(){
        $status_array = (new Feedbacks())->status_array();
        $status_color_array = (new Feedbacks())->status_color_array();
        return Grid::make(new Feedbacks(), function (Grid $grid) use($status_array, $status_color_array){
            $grid->column('id')->sortable();
            $grid->column("user", '会员信息')->width("370px")->display(function(){
                return admin_show_user_data($this->user);
            });
            $grid->column('type');
            $grid->column('content');
            $grid->column('contact');
            $grid->column('images')->display(function ($images) {
                return json_decode($images, true);
            })->image('', 60, 60);
            $grid->column('status')->using($status_array)->label($status_color_array);
            $grid->column('admin_remark');
            $grid->column('created_at');
            // $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
            $grid->disableCreateButton();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id){
        return Show::make($id, new Feedbacks(['user']), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('user.nickname', '会员昵称');
            $show->field('user.avatar', '会员头像')->image("", 60, 60);
            $show->field('type');
            $show->field('content');
            $show->field('contact');
            $show->field('images')->as(function(){
                return json_decode($this->images, true);
            })->image('', 80, 80);
            $show->field('status')->using((new Feedbacks())->status_array());
            $show->field('admin_remark');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(){
        return Form::make(new Feedbacks(), function (Form $form) {
            $form->display('id');
            $form->display('user_id');
            $form->display('type');
            $form->display('content');
            $form->display('contact');
            $form->multipleImage('images')->saving(function ($paths) {
                return json_encode($paths);
            })->disable();
            $form->divider();
            $form->radio('status')->options((new Feedbacks())->status_array())->required();
            $form->text('admin_remark');

            // $form->display('created_at');
            // $form->display('updated_at');

            $form->saving(function (Form $form) {
                $form->deleteInput(['user_id', 'type', 'content', 'contact', 'images', 'created_at', 'updated_at']);
                if($form->admin_remark == null){
                    $form->admin_remark = "";
                }
            });
        });
    }
}
