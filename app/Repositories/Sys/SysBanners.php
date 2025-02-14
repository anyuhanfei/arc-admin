<?php

namespace App\Repositories\Sys;

use App\Models\Sys\SysBanners as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * 轮播图表数据仓库
 */
class SysBanners extends EloquentRepository{
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
     * 链接类型集
     *
     * @return array
     */
    public function link_type_array():array{
        return (new $this->eloquentClass())->link_type_array();
    }

    /**
     * 内链集
     *
     * @return array
     */
    public function internal_link_array():array{
        return (new $this->eloquentClass())->internal_link_array();
    }

    /**
     * 获取指定位置的轮播图列表
     *
     * @param string $site
     * @return Collection
     */
    public function get_datas_by_site(string $site):Collection{
        return $this->eloquentClass::site($site)->get();
    }
}
