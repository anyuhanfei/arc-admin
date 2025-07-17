<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 基础数据仓库
 */
trait BaseRepository{

    /**
     * 创建数据
     *
     * @param array $params 参数
     * @return EloquentModel
     */
    public function create_data(array $params):EloquentModel{
        return $this->eloquentClass::create($params);
    }

    /**
     * 更新数据
     *
     * @param int $id ID
     * @param array $params 要更新的参数
     * @return int 更新的行数
     */
    public function update_data(int $id, array $params):int{
        return $this->eloquentClass::where("id", $id)->update($params);
    }

    /**
     * 删除数据
     *
     * @param int|array $ids ID集合
     * @return int 删除的行数
     */
    public function delete_data(int|array $ids):int{
        return $this->eloquentClass::whereIn("id", $ids)->delete();
    }

    /**
     * 获取指定id的数据
     *
     * @param int $id ID
     * @return EloquentModel|null
     */
    public function get_data_by_id(int $id):?EloquentModel{
        return $this->eloquentClass::where("id", $id)->first();
    }

    /**
     * 获取全部数据
     *
     * @return Collection
     */
    public function get_datas():Collection{
        return $this->eloquentClass::get();
    }

    /**
     * 以列表的形式获取数据
     *
     * @param int $limit 每页数量
     * @return LengthAwarePaginator
     */
    public function get_list(int $limit):LengthAwarePaginator{
        return $this->eloquentClass::fastPaginate($limit);
    }
}