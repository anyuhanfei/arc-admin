<?php

namespace App\Admin\Controllers\Article;

use App\Repositories\Article\ArticleCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

/**
 * 文章分类模块控制器
 */
class ArticleCategoryController extends AdminController{
    // 图片字段是否使用
    protected bool $field_image_enable = true;

    protected function grid(){
        return Grid::make(new ArticleCategory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $this->field_image_enable ? $grid->column('image')->image('', 40, 40)->width("15%") : '';
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like("name");
            });
            $grid->disableRowSelector();
            $grid->disableViewButton();
        });
    }

    protected function form(){
        return Form::make(new ArticleCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $this->field_image_enable ? $this->admin_image_compress(admin_image_field($form->image('image')->required())) : '';

            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableViewButton();
            $form->disableViewCheck();
        });
    }

    public function get_categories(Request $request){
        $name = $request->get('q');
        return (new ArticleCategory())->admin_get_categories($name);
    }


    protected function admin_image_compress($image_obj){
        return $image_obj->compress([
            'width' => 320,
            'height' => 320,
            'quality' => 70,
            'crop' => false,
            'noCompressIfLarger' => true,
        ]);
    }
}
