<?php

namespace App\Admin\Controllers\Sys;

use App\Repositories\Sys\SysSetting;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 系统设置模块控制器
 */
class SysSettingController extends AdminController{
    protected $list;

    public function __construct(){
        $this->list = (new SysSetting())->set_list();
    }

    public function index(Content $content){
        return $content->body($this->grid());
    }

    protected function grid(){
        return Form::make(new SysSetting(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
                $tools->disableDelete();
                $tools->disableList();
            });
            $list = $this->list;
            foreach(array_keys($list) as $category){
                $form->tab($category, function(Form $form) use($list, $category){
                    foreach($list[$category] as $key=> $value_arr){
                        $set_obj = (new SysSetting())->use_key_get_data($key);
                        if(!$set_obj){
                            $set_obj = (new SysSetting())->create_data($key);
                        }
                        $field_key = "sys.{$key}";
                        switch($value_arr['type']){
                            case "select":
                                $field = $form->select($field_key, $value_arr['title'])->options(array_combine($value_arr['options'], $value_arr['options']));
                                break;
                            case "radio":
                                $field = $form->radio($field_key, $value_arr['title'])->options(array_combine($value_arr['options'], $value_arr['options']));
                                break;
                            case "onoff":
                                $field = $form->switch($field_key, $value_arr['title']);
                                break;
                            case "image":
                                $field = admin_image_field($form->image($field_key, $value_arr['title'])->required());
                                break;
                            case "number":
                                $field = $form->number($field_key, $value_arr['title']);
                                break;
                            default:
                                $field = $form->text($field_key, $value_arr['title']);
                                break;
                        }
                        $field = $field->value($set_obj->value);
                        // 如果有备注才会展示备注
                        if(!empty($value_arr['help'])){
                            $field = $field->help($value_arr['help']);
                        }
                    }
                });
            }
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }

    protected function form(){
        return Form::make(new SysSetting(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
                $tools->disableDelete();
                $tools->disableList();
            });
            // 这里仅仅是为了图片上传不报错
            $list = $this->list;
            foreach(array_keys($list) as $category){
                $form->tab($category, function(Form $form) use($list, $category){
                    foreach($list[$category] as $key=> $value_arr){
                        $field_key = "sys.{$key}";
                        switch($value_arr['type']){
                            case "image":
                                admin_image_field($form->image($field_key, $value_arr['title'])->required()->autoSave(false));
                                break;
                            default:
                                $form->hidden($field_key, $value_arr['title']);
                                break;
                        }
                    }
                });
            }
            $form->saving(function (Form $form) {
                if($form->sys != null){
                    foreach($form->sys as $key=> $value){
                        if($value == '' || $value == null){
                            continue;
                        }
                        (new SysSetting())->use_key_update_value($key, $value);
                    }
                    return $form->response()->success("配置成功");
                }
            });
        });
    }
}
