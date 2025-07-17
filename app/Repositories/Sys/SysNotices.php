<?php

namespace App\Repositories\Sys;

use App\Enums\SysNotices\StatusEnum;
use App\Models\Sys\SysNotices as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;

/**
 * 系统公告表数据仓库
 */
class SysNotices extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 获取公告类型
     *
     * @return string
     */
    public static function get_type():string{
        return Model::$type;
    }

    /**
     * 初始化数据
     * （如果是单条情况，需要初始化出一条数据）
     *
     * @return void
     */
    public function init(){
        $data = $this->get_first_data();
        if(!$data){
            $this->eloquentClass::create([
                'title'=> ''
            ]);
        }
    }

    /**
     * 获取首条公告（通常是单条模式使用）
     *
     * @return EloquentModel
     */
    public function get_first_data():EloquentModel|null{
        return $this->eloquentClass::orderby("id", 'desc')->first();
    }

    /**
     * 获取指定id的数据
     *
     * @param int $id
     * @return EloquentModel
     */
    public function get_data_by_id(int $id):EloquentModel|null{
        return $this->eloquentClass::id($id)->first();
    }

    /**
     * 获取全部的公告id
     *
     * @return array
     */
    public function get_ids():array{
        return $this->eloquentClass::pluck("id")->toArray();
    }

    /**
     * 获取公告列表
     *
     * @param integer $limit
     * @return void
     */
    public function get_list(int $limit = 10):LengthAwarePaginator{
        return $this->eloquentClass::publish()->orderby("id", 'desc')->fastPaginate($limit);
    }

    /**
     * 设置已读状态
     *
     * @param integer $user_id
     * @param integer $id
     * @return void
     */
    public function set_read_status_by_id_user(int $user_id, int $id){
        Redis::sadd("snread:{$user_id}", $id);
    }

    /**
     * 获取已读公告id
     *
     * @param integer $user_id
     * @return void
     */
    public function get_read_ids_by_user(int $user_id){
        return Redis::smembers("snread:{$user_id}") ?? [];
    }

    /**
     * 获取文章是否已读
     *
     * @param integer $user_id
     * @param integer $id
     * @return void
     */
    public function get_read_status_by_id_user(int $user_id, int $id){
        return Redis::sismember("snread:{$user_id}", $id);
    }
}
