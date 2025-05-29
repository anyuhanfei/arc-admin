<?php

namespace App\Admin\Controllers\Sys;

use App\Enums\SysBanners\InternalLikeEnum;
use App\Enums\SysBanners\LinkTypeEnum;
use App\Enums\SysBanners\SiteEnum;
use App\Repositories\Article\Articles;
use App\Repositories\Article\ArticleCategories;
use App\Repositories\Sys\SysBanners;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 轮播图模块控制器
 */
class SysBannersController extends AdminController{
    public bool $module_enable;  # 模块是否启用
    public bool $field_link_enable;  # 字段url是否启用

    public function __construct(){
        $this->module_enable = true;
        $this->field_link_enable = true;
    }


    protected function grid(){
        if($this->module_enable == false){
            return admin_error('error', '当前已关闭轮播图功能，请删除此目录或联系管理员打开轮播图功能');
        }
        return Grid::make(new SysBanners(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            if(count(SiteEnum::getKeys()) != 1){
                $grid->column("site", '位置');
            }
            $grid->column('image')->image('', 60, 60);
            if($this->field_link_enable){
                $grid->column('link_type', '链接类型')->using(LinkTypeEnum::getDescriptions());
                $grid->column('link', '链接')->display(function($link){
                    switch($this->link_type){
                        case "internal_link":
                            return InternalLikeEnum::getDescriptions()[$link];
                        case 'article_id':
                            $article = (new Articles())->get_data_by_id($link);
                            return $article ? $article->title : '文章已删除';
                            break;
                        case "external_link":
                        default:
                            return $link;
                            break;
                    }
                    // if()
                    // if($this->link_type == "external_link"){
                    //     return "<a href='{$link}' target='_blank'>{$link}</a>";
                    // }else{
                    //     return $link;
                    // }
                });
            }

            $grid->selector(function (Grid\Tools\Selector $selector){
                if($this->field_link_enable){
                    $selector->select('link_type', '链接类型', LinkTypeEnum::getDescriptions());
                }
                if(count(SiteEnum::getKeys()) != 1){
                    $selector->select('site', '位置', SiteEnum::getDescriptions());
                }
            });

            $grid->disableFilterButton();
            $grid->disableViewButton();
        });
    }

    protected function form(){
        return Form::make(new SysBanners(), function (Form $form) {
            $form->display('id');
            if(count(SiteEnum::getKeys()) == 1){
                $form->hidden("site")->value(SiteEnum::HOME);
            }else{
                $form->select("site", '位置')->options(SiteEnum::getDescriptions())->required();
            }
            admin_image_field($form->image('image')->required());
            if($this->field_link_enable){
                $form->hidden('link');
                $form->select("link_type", '链接类型')->options(LinkTypeEnum::getDescriptions())->required()->when(['external_link'], function(Form $form){
                    $form->url('external_link', '链接')
                         ->rules('required_if:link_type,external_link')
                         ->value($form->model()->link_type == 'external_link' ? $form->model()->link : '');
                })->when(['internal_link'], function(Form $form){
                    $form->radio("internal_link", '链接')
                         ->options(InternalLikeEnum::getDescriptions())
                         ->rules('required_if:link_type,internal_link')
                         ->value($form->model()->link_type == 'internal_link' ? $form->model()->link : '');
                })->when(['article_id'], function(Form $form){
                    $category_id = 0;
                    if($form->isEditing() && $form->model()->link_type == 'article_id'){
                        $article = (new Articles())->get_data_by_id($form->model()->link);
                        $category_id = $article ? $article->category_id : 0;
                    }
                    $form->select('category_id', '选择文章分类')
                         ->options("get/article/categories")
                         ->load("article_id", '/get/articles/list')
                         ->rules('required_if:link_type,article_id')
                         ->value($category_id);
                    $form->select("article_id", '选择文章')
                         ->rules('required_if:link_type,article_id')
                         ->value($form->model()->link_type == 'article_id' ? $form->model()->link : '');
                })->default("nothing");
                $form->saving(function(Form $form){
                    switch($form->link_type){
                        case "external_link":
                            $form->link = $form->external_link;
                            break;
                        case "internal_link":
                            $form->link = $form->internal_link;
                            break;
                        case "article_id":
                            $form->link = $form->article_id;
                            break;
                    }
                    $form->deleteInput("external_link");
                    $form->deleteInput("internal_link");
                    $form->deleteInput("category_id");
                    $form->deleteInput("article_id");
                    if($form->link == null){
                        $form->link = "";
                    }
                });
            }
            $form->disableViewCheck();
            $form->disableViewButton();
        });
    }
}
