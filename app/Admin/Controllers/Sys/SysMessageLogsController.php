<?php

namespace App\Admin\Controllers\Sys;

use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Metrics\Card;

use App\Repositories\Sys\SysMessageLogs;
use App\Repositories\Users\Users;

use App\Enums\SysMessageLogs\SendTypeEnum;
use App\Enums\SysMessageLogs\SendUsersGroupEnum;

/**
 * 系统消息模块控制器
 *
 * 系统消息一般有以下几种情况：
 *    短消息类：使用 title 字段作为内容
 *    文章类：使用 title 字段作为标题，使用 content 字段作为内容
 */
class SysMessageLogsController extends AdminController{
    // 字段标题、图片是否使用
    protected bool $field_title_enable = true;
    protected bool $field_image_enable = false;
    // 内容是否使用富文本格式
    protected bool $field_content_editor_enable = true;
    protected $user_ids;
    protected $send_users_group;
    protected $content;


    protected function grid(){
        return Grid::make(new SysMessageLogs(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            // 发送消息类型（只有一类时隐藏）
            if(count(SendTypeEnum::getDescriptions()) > 1){
                $grid->column('send_type')->using(SendTypeEnum::getDescriptions());
            }
            // 发送用户组（只有一类时隐藏）
            if(count(SendUsersGroupEnum::getDescriptions()) > 1){
                $grid->column('send_users_group')->using(SendUsersGroupEnum::getDescriptions());
            }
            // 发送用户列表
            $grid->column('user_ids')->width('20%')->display(function(){
                if($this->user_ids == 0){
                    return "所有" . SendUsersGroupEnum::getDescription($this->send_users_group);
                }
                $users = (new Users())->get_datas_by_ids(comma_str_to_array($this->user_ids));
                $str = '<span class="intro">';
                foreach($users as $user){
                    $str .= "ID: {$user->id}&nbsp;&nbsp;昵称：{$user->nickname}&nbsp;&nbsp;账号：{$user->account}<br/>";
                }
                return $str . '</span>';
            });
            // 标题
            if($this->field_title_enable){
                $grid->column('title')->width('15%');
            }
            // 图片
            if($this->field_image_enable){
                $grid->column('image')->image("", 60, 60);
            }
            // 内容
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

            $grid->selector(function (Grid\Tools\Selector $selector){
                if(count(SendTypeEnum::getDescriptions()) > 1){
                    $selector->select('send_type', SendTypeEnum::getDescriptions());
                }
                if(count(SendUsersGroupEnum::getDescriptions()) > 1){
                    $selector->select('send_users_group', SendUsersGroupEnum::getDescriptions());
                }
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
            if(count(SendTypeEnum::getDescriptions()) > 1){
                $show->field('send_type')->using(SendTypeEnum::getDescriptions());
            }
            if(count(SendUsersGroupEnum::getDescriptions()) > 1){
                $show->field('send_users_group')->using(SendUsersGroupEnum::getDescriptions());
            }
            $show->field('user_ids')->as(function(){
                if($this->user_ids == 0){
                    return "所有" . SendUsersGroupEnum::getDescription($this->send_users_group);
                }
                $users = (new Users())->get_datas_by_ids(comma_str_to_array($this->user_ids));
                $str = '<span class="intro">';
                foreach($users as $user){
                    $str .= "ID: {$user->id}&nbsp;&nbsp;昵称：{$user->nickname}&nbsp;&nbsp;账号：{$user->account}<br/>";
                }
                return $str . '</span>';
            });
            if($this->field_title_enable){
                $show->field('title');
            }
            if($this->field_image_enable){
                $show->field('image')->image();
            }
            $show->field('content')->unescape();
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new SysMessageLogs(), function (Form $form) {
            if($form->isCreating()){
                // TODO::暂时只有创建时才能选择会员
                if(count(SendUsersGroupEnum::getDescriptions()) > 1){
                    $form->radio("send_users_group")->options(SendUsersGroupEnum::getDescriptions())->default(SendUsersGroupEnum::USERS)->required()->when(SendUsersGroupEnum::USERS, function (Form $form){
                        $form->multipleSelect('user_ids', '选择用户')->options("get/users")->help('不选择表示所有用户')->saving(function ($value) {
                            return $value ? implode(',', $value) : '0';
                        });
                    });
                }else{
                    $form->hidden("send_users_group")->default(SendUsersGroupEnum::USERS);
                    $form->multipleSelect('user_ids', '选择用户')->options("get/users")->help('不选择表示所有用户')->saving(function ($value) {
                        return $value ? implode(',', $value) : '0';
                    });
                }
            }
            // 选择发送的消息类型（只有一类时隐藏）
            if(count(SendTypeEnum::getDescriptions()) > 1){
                $form->select("send_type")->options(SendTypeEnum::getDescriptions())->default(SendTypeEnum::SYS)->required();
            }else{
                $form->hidden("send_type")->default(SendTypeEnum::SYS);
            }
            // 填写标题
            if($this->field_title_enable){
                $form->text('title')->required();
            }else{
                $form->hidden("title");
            }
            // 上传图片
            if($this->field_image_enable){
                admin_form_media_selector_field($form->mediaSelector('image'), 1, ['image'])->required();
            }else{
                $form->hidden("image");
            }
            // 填写内容
            if($this->field_content_editor_enable){
                $form->editor('content')->height('600')->required();
            }else{
                $form->textarea("content")->rows(5)->required();
            }
            $form->saving(function (Form $form) {
                $form->title = $form->title ?? '';
                $form->image = $form->image ?? '';
            });
            $form->saved(function(Form $form, $result){
                // 更新未读状态
                $user_ids = $form->repository()->model()->user_ids;
                if($user_ids == 0){
                    $user_ids = (new Users())->get_ids();
                }else{
                    $user_ids = comma_str_to_array($user_ids);
                }
                (new SysMessageLogs())->set_data_as_unread($user_ids, $form->getKey(), $form->repository()->model()->send_type);
            });
        });
    }
}
