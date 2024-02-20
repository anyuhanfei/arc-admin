<?php

namespace App\Repositories\Article;

use App\Models\Article\ArticleCategory as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 文章分类表数据仓库
 */
class ArticleCategory extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 后台管理使用的数据查询
     *
     * @param string $name
     * @return void
     */
    public function admin_get_categories(string|null $name = ''){
        $name = $name ?? '';
        return $this->eloquentClass::name($name)->get(['id', DB::raw("name as text")]);
    }

    /**
     * 获取全部数据
     *
     * @return Collection
     */
    public function get_all_data():Collection{
        return $this->eloquentClass::select('id', 'name', 'image')->get();
    }
}
