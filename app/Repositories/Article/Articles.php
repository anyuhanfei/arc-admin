<?php

namespace App\Repositories\Article;

use App\Models\Article\Articles as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * 文章表数据仓库
 */
class Articles extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function admin_get_datas_by_category(int $category_id){
        return $this->eloquentClass::categoryId($category_id)->get(['id', DB::raw("title as text")]);
    }

    /**
     * 获取指定分类id的文章列表
     *
     * @param integer $category_id
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_list_by_category(int $category_id, int $page, int $limit):Collection{
        return $this->eloquentClass::categoryId($category_id)->status('normal')->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * 获取全部文章数据
     *
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_list(int $page, int $limit):LengthAwarePaginator{
        return $this->eloquentClass::status('normal')->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * 获取指定id的文章数据
     *
     * @param integer $id
     * @return EloquentModel|null
     */
    public function get_data_by_id(int $id):EloquentModel|null{
        return $this->eloquentClass::id($id)->first();
    }
}
