<?php

namespace App\Admin\Controllers\Sys;

use App\Repositories\Sys\SysNotices;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Metrics\Card;

/**
 * 系统公告模块控制器
 */
class SysNoticesController extends AdminController{
    // 模块是否启用
    protected bool $module_enable = true;
    // 字段image是否启用
    protected bool $field_image_enable = true;
    // 项目中公告的类型
    protected string $type;

    public function __construct(){
        $this->type = SysNotices::get_type();
    }

    protected function grid(){
        if($this->module_enable == false){
            return admin_error('error', '当前已关闭公告功能，请删除此目录或联系管理员打开公告功能');
        }
        return Grid::make(new SysNotices(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            switch($this->type) {
                case '单条富文本':
                    (new SysNotices())->init();
                    $grid->column('');
                    $grid->column('title');
                    $grid->column('content')->width('15%')->display('')->modal(function ($modal) {
                        $modal->title($this->title);
                        $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
                        $card = (new Card(null, ''))->header($this->content);
                        return "<div style='padding:10px 10px 0'>$card</div>";
                    });
                    $grid->disableDeleteButton();
                    $grid->disableViewButton();
                    $grid->disableCreateButton();
                    $grid->disableFilter();
                    break;
                case "多条文字":
                    $grid->column('id')->sortable();
                    $grid->column('title', '内容')->width("50%");
                    break;
                case '多条富文本':
                    $grid->column('id')->sortable();
                    $grid->column('title')->width("30%");
                    $grid->column('content')->display('')->modal(function ($modal) {
                        $modal->title($this->title);
                        $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
                        $card = (new Card(null, ''))->header($this->content);
                        return "<div style='padding:10px 10px 0'>$card</div>";
                    });
                    break;
                default:
                    (new SysNotices())->init();
                    $grid->column('');
                    $grid->column('title', '内容')->width("60%");
                    $grid->disableViewButton();
                    $grid->disableDeleteButton();
                    $grid->disableCreateButton();
                    $grid->disableFilter();
                    break;
            }
            $this->field_image_enable ? $grid->column('image')->image('', 40, 40)->width("15%") : '';
            if($this->type == '多条文字' || $this->type == "多条富文本"){
                $grid->column('created_at');
            }
            $grid->disableRowSelector();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
            });
        });
    }

    protected function detail($id){
        return Show::make($id, new SysNotices(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content')->unescape();
            $show->field('image')->image();
            $show->field('created_at');
            $show->field('updated_at');
            $show->panel()->tools(function ($tools) {
                $tools->disableDelete();
            });
        });
    }

    protected function form(){
        return Form::make(new SysNotices(), function (Form $form) {
            $form->hidden('id');
            switch($this->type) {
                case '单条富文本':
                case '多条富文本':
                    $form->text('title')->required();
                    $form->editor('content')->height('600')->required();
                    break;
                default:
                    $form->text('title', '内容')->required();
                    $form->hidden('content');
                    break;
            }
            $this->field_image_enable ? admin_image_field($form->image('image')->required()) : '';
            $form->saving(function (Form $form) {
                $form->content = $form->content ?? '';
            });
            $form->disableViewButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableDeleteButton();
        });
    }
}