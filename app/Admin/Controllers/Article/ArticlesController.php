<?php

namespace App\Admin\Controllers\Article;

use App\Enums\StatusEnum;
use App\Repositories\Article\Articles;
use App\Repositories\Article\ArticleCategories;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Http\Request;

/**
 * 文章模块控制器
 */
class ArticlesController extends AdminController{
    // 图片、简介、关键词字段是否使用
    protected bool $field_image_enable = false;
    protected bool $field_intro_enable = false;
    protected bool $field_keyword_enable = false;

    protected function grid(){
        return Grid::make(new Articles(['category']), function (Grid $grid){
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('category.name', '文章分类')->width("10%");
            $grid->column('title')->width("25%")->display(function(){
                return "<h5>{$this->title}</h5><span class='intro'>{$this->intro}</span>";
            });
            $this->field_image_enable ? $grid->column('image')->image('', 40, 40)->width("8%") : '';
            $this->field_keyword_enable ? $grid->column('keyword')->width("15%")->explode(',')->label() : '';
            $grid->column('author');
            $grid->column('content')->display('')->modal(function ($modal) {
                $modal->title($this->title);
                $this->content == null ? $modal->icon('feather ') : $modal->icon('feather icon-eye');
                $card = (new Card(null, ''))->header($this->content);
                return "<div style='padding:10px 10px 0'>$card</div>";
            });
            $grid->column('status')->using(StatusEnum::getDescriptions())->label(StatusEnum::getColors());
            $grid->column('created_at');
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $categories = (new ArticleCategories())->admin_get_datas_by_name()->toArray();
                $selector->select('category_id', '文章分类', array_combine(array_column($categories, 'id'), array_column($categories, 'text')));
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
                $this->field_keyword_enable ? $filter->like('keyword') : '';
            });
            Admin::style(
                <<<CSS
                    .intro {
                        color:gray;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-indent: 2em;
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
        return Show::make($id, new Articles(['category']), function (Show $show) {
            $show->field('id');
            $show->field('category_id', '文章分类id');
            $show->field('category.name', '文章分类名称');
            $show->field('title');
            $show->field('intro');
            $show->field('image')->image("", 100, 100);
            $show->field('author');
            $show->field('keyword')->explode(',')->label();
            $show->field('content')->unescape();
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new Articles(), function (Form $form) {
            $form->display('id');
            $form->select('category_id')->options("get/article/categories")->required();
            $form->text('title')->required();
            $this->field_intro_enable ? $form->textarea('intro')->rows(3) : '';
            $this->field_image_enable ? admin_form_media_selector_field($form->mediaSelector('image'), 1, ['image'])->required() : '';
            $form->text('author')->required();
            $this->field_keyword_enable ? $form->tags('keyword')->help("输入一个关键词后，按下空格键，再按下回车键，即成功添加一个关键词。")->saving(function ($value) {return is_array($value) ? implode(',', $value) : '';}) : '';
            $form->radio("status")->options(StatusEnum::getDescriptions())->default("hidden")->required();
            $form->editor('content')->height('600')->required();
            $form->saving(function(Form $form){
                $form->intro = $form->intro ?? '';
                $form->keyword = $form->keyword ?? '';
                $form->image = $form->image ?? '';
            });
        });
    }

    public function get_articles_list(Request $request){
        $category_id = $request->get('q', 0);
        return (new Articles())->admin_get_datas_by_category($category_id);
    }
}
