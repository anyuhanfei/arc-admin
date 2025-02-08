<?php

namespace App\Repositories\Sys;

use App\Models\Sys\SysMessageLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 系统消息表数据仓库
 */
class SysMessageLog extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 向指定会员发送系统消息
     *
     * @param integer|array $user_ids 会员id或会员id集
     * @param string $title 标题
     * @param string $content 内容
     * @param string $image 图片
     * @param string $relevance_data 关联数据,格式一般为 <type>:<id>
     * @return void
     */
    public function send_message(int|array $user_ids, string $title, string $content, string $image = '', string $relevance_data = ""){
        return $this->eloquentClass::create([
            'user_ids' => $user_ids,
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'relevance_data' => $relevance_data,
        ]);
    }

    /**
     * 获取会员的消息列表
     *
     * @param integer $user_id
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_list_by_user(int $user_id, int $limit):LengthAwarePaginator{
        return $this->eloquentClass::userIds($user_id)->orderby("id", 'desc')->paginate($limit);
    }

    /**
     * 获取会员的消息详情
     *
     * @param integer $user_id
     * @param integer $message_id
     * @return EloquentModel|null
     */
    public function get_data_by_id(int $user_id, int $message_id):EloquentModel|null{
        return $this->eloquentClass::userIds($user_id)->id($message_id)->first();
    }

    /**
     * 会员系统消息是否已读模块
     * 方法有：获取、设置为已读、设置为未读(用于后台修改系统消息后)
     *
     * redis 键名全称：sys_message_read_status:{user_id}
     *
     * @param integer $user_id
     * @param integer $message_id
     * @return int  0:未读 1:已读
     */
    public function get_read_status_by_id(int $user_id, int $message_id):int{
        return Redis::getbit("sysmsgrs:{$user_id}", $message_id);
    }

    public function set_read_status_by_id_user_by_id(int $user_id, int $message_id){
        Redis::setbit("sysmsgrs:{$user_id}", $message_id, 1);
    }

    public function del_read_status_by_id(int $user_id, int $message_id){
        Redis::setbit("sysmsgrs:{$user_id}", $message_id, 0);
    }
}
