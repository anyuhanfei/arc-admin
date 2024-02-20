<?php

namespace App\Repositories\Idx;

use App\Models\Idx\IdxBanner as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 轮播图表数据仓库
 */
class IdxBanner extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 获取位置集
     *
     * @return array
     */
    public function site_array():array{
        return (new $this->eloquentClass())->site_array();
    }

    /**
     * 获取指定位置的轮播图列表
     *
     * @param string $site
     * @return Collection
     */
    public function use_site_get_list(string $site):Collection{
        return $this->eloquentClass::site($site)->select('id', 'image', 'url')->get();
    }
}
