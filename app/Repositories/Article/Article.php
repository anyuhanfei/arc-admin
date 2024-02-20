<?php

namespace App\Repositories\Article;

use App\Models\Article\Article as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 文章表数据仓库
 */
class Article extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 获取指定分类id的文章列表
     *
     * @param integer $category_id
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function use_category_get_list(int $category_id, int $page, int $limit):Collection{
        return $this->eloquentClass::categoryId($category_id)->page($page, $limit)->get();
    }

    /**
     * 获取全部文章数据
     *
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_all_data(int $page, int $limit):Collection{
        return $this->eloquentClass::page($page, $limit)->get();
    }

    /**
     * 获取指定id的文章数据
     *
     * @param integer $id
     * @return EloquentModel|null
     */
    public function use_id_get_data(int $id):EloquentModel|null{
        return $this->eloquentClass::id($id)->first();
    }
}
