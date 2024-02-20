<?php

namespace App\Admin\Controllers\Idx;

use App\Repositories\Idx\IdxBanner;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 轮播图模块控制器
 */
class IdxBannerController extends AdminController{
    protected bool $module_enable;  # 模块是否启用
    protected bool $field_url_enable;  # 字段url是否启用
    protected array $site_array;  # 轮播图位置集

    public function __construct(){
        $this->site_array = (new IdxBanner())->site_array();
        $this->module_enable = true;
        $this->field_url_enable = false;
    }


    protected function grid(){
        if($this->module_enable == false){
            return admin_error('error', '当前已关闭轮播图功能，请删除此目录或联系管理员打开轮播图功能');
        }
        return Grid::make(new IdxBanner(), function (Grid $grid) {
            $grid->column('id')->sortable();
            if(count($this->site_array) != 1){
                $grid->column("site", '位置');
                $grid->selector(function (Grid\Tools\Selector $selector){
                    $selector->select('site', '位置', array_combine($this->site_array, $this->site_array));
                });
            }
            $grid->column('image')->image('', 60, 60);
            $this->field_url_enable ? $grid->column('url') : '';

            $grid->disableFilterButton();
            $grid->disableViewButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal("site")->select(array_combine($this->site_array, $this->site_array));
            });
        });
    }

    protected function form(){
        return Form::make(new IdxBanner(), function (Form $form) {
            $form->display('id');
            if(count($this->site_array) == 1){
                $form->hidden("site")->value($this->site_array[0]);
            }else{
                $form->select("site", '位置')->options(array_combine($this->site_array, $this->site_array))->required();
            }
            admin_image_field($form->image('image')->required());
            $this->field_url_enable ? $form->url('url')->required() : '';
        });
    }
}
