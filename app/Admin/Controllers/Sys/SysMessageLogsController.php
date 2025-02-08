<?php

namespace App\Admin\Controllers\Sys;

use App\Repositories\Sys\SysMessageLogs;
use App\Repositories\Users\Users;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Metrics\Card;

/**
 * 系统消息模块控制器
 *
 * 系统消息一般有以下几种情况：
 *    短消息类：使用 title 字段作为内容
 *    文章类：使用 title 字段作为标题，使用 content 字段作为内容
 */
class SysMessageLogsController extends AdminController{
    // 字段标题、图片是否使用
    protected bool $field_title_enable = false;
    protected bool $field_image_enable = false;
    // 内容是否使用富文本格式
    protected bool $field_content_editor_enable = true;


    protected function grid(){
        return Grid::make(new SysMessageLogs(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('user_ids', '发送会员')->width('30%')->display(function(){
                if($this->user_ids == 0){
                    return "所有会员";
                }
                $users = (new Users())->get_datas_by_ids(comma_str_to_array($this->user_ids));
                $str = '<span class="intro">';
                foreach($users as $user){
                    $str .= "ID: {$user->id}&nbsp;&nbsp;昵称：{$user->nickname}&nbsp;&nbsp;账号：{$user->account}<br/>";
                }
                return $str . '</span>';
            });
            $this->field_title_enable ? $grid->column('title') : "";
            $this->field_image_enable ? $grid->column('image')->image("", 60, 60) : "";
            if(($this->field_title_enable == false && $this->field_content_editor_enable == true) || $this->field_content_editor_enable == false){
                // 没有标题、内容是富文本 或 本身就禁止了富文本。强制展示富文本源码
                $grid->column('content')->limit(100, '...')->width("30%");
            }else{
                if($this->field_content_editor_enable == true){
                    $grid->column('content')->display('')->modal(function ($modal) {
                        $modal->title($this->title);
                        $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
                        $card = (new Card(null, ''))->header($this->content);
                        return "<div style='padding:10px 10px 0'>$card</div>";
                    });
                }
            }
            $grid->column('created_at');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
            Admin::style(
                <<<CSS
                    .intro {
                        color:gray;
                        display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                    }
                CSS
            );
            Admin::script(
                <<<JS
                    $(".intro").click(function(){
                        $(this).css("-webkit-line-clamp", "unset");
                    });
                JS
            );
        });
    }

    protected function detail($id){
        return Show::make($id, new SysMessageLogs(), function (Show $show) {
            $show->field('id');
            $show->field('user_ids');
            $show->field('title');
            $show->field('image');
            $show->field('content');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new SysMessageLogs(), function (Form $form) {
            $form->multipleSelect('user_ids', '选择会员')->options("get/users")->help('不选择表示所有会员')->saving(function ($value) {
                return $value ? implode(',', $value) : '0';
            });
            $this->field_title_enable ? $form->text('title')->required() : $form->hidden("title");
            $this->field_image_enable ? admin_image_field($form->image('image')->required()) : $form->hidden("image");
            $this->field_content_editor_enable ? $form->editor('content')->height('600')->required() : $form->textarea("content")->rows(5)->required();
            $form->saving(function (Form $form) {
                $form->title = $form->title ?? '';
                $form->image = $form->image ?? '';
            });
            $form->saved(function(Form $form, $result){
                // 如果是修改，则要清除本条信息的已读状态
                if($form->isEditing()){
                    $message_id = $form->getKey();
                    if($form->model()->user_ids == 0){
                        $user_ids_list = (new Users())->get_ids();
                    }else{
                        $user_ids_list = comma_str_to_array($form->model()->user_ids);
                    }
                    $repository = new SysMessageLogs();
                    foreach($user_ids_list as $user_id){
                        $repository->del_read_status_by_id($user_id, $message_id);
                    }
                }
            });
        });
    }
}
