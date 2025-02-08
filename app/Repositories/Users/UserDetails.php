<?php

namespace App\Repositories\Users;

use App\Models\Users\UserDetails as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 会员详情表数据仓库
 */
class UserDetails extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 创建数据
     *   一般伴随创建会员是调用
     *
     * @param integer $id
     * @return EloquentModel
     */
    public function create_data(int $id):EloquentModel{
        return $this->eloquentClass::create([
            'id'=> $id,
        ]);
    }

    /**
     * 修改会员中指定的数据
     *
     * @param integer $user_id
     * @param array $params
     * @return void
     */
    public function update_datas_by_user(int $user_id, array $params):int{
        return $this->eloquentClass::where("id", $user_id)->update($params);
    }

    /**
     * 通过会员id获取会员详情数据
     *
     * @param integer $user_id
     * @return EloquentModel|null
     */
    public function get_data_by_id(int $user_id):EloquentModel|null{
        return $this->eloquentClass::id($user_id)->first();
    }
}
