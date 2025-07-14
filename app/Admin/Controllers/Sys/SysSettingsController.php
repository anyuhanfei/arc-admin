<?php

namespace App\Admin\Controllers\Sys;

use App\Repositories\Sys\SysSettings;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 系统设置模块控制器
 */
class SysSettingsController extends AdminController{
    protected $list;

    public function __construct(){
        $this->list = (new SysSettings())->set_list();
    }

    public function index(Content $content){
        return $content->body($this->grid());
    }

    protected function grid(){
        return Form::make(new SysSettings(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
                $tools->disableDelete();
                $tools->disableList();
            });
            $list = $this->list;
            foreach(array_keys($list) as $category){
                $form->tab($category, function(Form $form) use($list, $category){
                    foreach($list[$category] as $key=> $value_arr){
                        $set_obj = (new SysSettings())->get_data_by_key($key);
                        if(!$set_obj){
                            $set_obj = (new SysSettings())->create_data($key);
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
                                $field = admin_form_media_selector_field($form->mediaSelector($field_key, $value_arr['title']), 1, ['image']);
                                break;
                            case "number":
                                $field = admin_form_number_field($form->text($field_key, $value_arr['title']), empty($value_arr['step']) ? '1' : $value_arr['step']);
                                break;
                            case "textarea":
                                $field = $form->textarea($field_key, $value_arr['title'])->rows(5);
                                break;
                            case "edit":
                                $field = $form->editor($field_key, $value_arr['title'])->height('600');
                                break;
                            default:
                                $field = $form->text($field_key, $value_arr['title']);
                                break;
                        }
                        // 既然配置了系统配置，那么就默认必填，但是如果是开关表单并选择了关闭，无法通过必填验证。
                        if($value_arr['type'] != 'onoff'){
                            $field = $field->required();
                        }
                        // 赋值
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
        return Form::make(new SysSettings(), function (Form $form) {
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
                                admin_form_media_selector_field($form->mediaSelector($field_key, $value_arr['title'])->required()->autoSave(false));
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
                        (new SysSettings())->update_value_by_key($key, $value);
                    }
                    return $form->response()->success("配置成功");
                }
            });
        });
    }
}
