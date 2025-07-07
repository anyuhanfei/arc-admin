<?php

namespace App\Repositories\Sys;

use App\Models\Sys\SysMessageLogs as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 系统消息表数据仓库
 */
class SysMessageLogs extends EloquentRepository{
    use \App\Repositories\BaseRepository;

    protected $eloquentClass = Model::class;

    /**
     * API:向指定会员发送系统消息
     *
     * @param integer|array $user_ids 会员id或会员id集
     * @param string $title 标题
     * @param string $content 内容
     * @param string $image 图片
     * @param string $relevance_data 关联数据,格式一般为 <type>:<id>
     * @return void
     */
    public function send_message(int|array $user_ids, string $title, string $content, string $image = '', string $relevance_data = ""){
        $data = $this->eloquentClass::create([
            'user_ids' => $user_ids,
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'relevance_data' => $relevance_data,
        ]);
        $this->set_data_as_unread($user_ids, $data->id);
        return $data;
    }

    /**
     * 获取会员的消息列表
     *
     * @param integer $user_id
     * @param string $type
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_list_by_user_type(int $user_id, string $type, int $page, int $limit):LengthAwarePaginator{
        return $this->eloquentClass::userIds($user_id)->type($type)->orderby("id", 'desc')->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * 获取会员的最新一条消息
     *
     * @param integer $user_id
     * @param string $type
     * @return EloquentModel|null
     */
    public function get_last_data_by_user_type(int $user_id, string $type):EloquentModel|null{
        return $this->eloquentClass::userIds($user_id)->type($type)->orderby("id", 'desc')->first();
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
     * 设置消息为未读
     *   执行此方法时，会员集合必须是已经处理好的，例如不能是0表示全部会员这种。
     *
     * @param integer|array $user_ids 会员id或会员id集
     * @param integer $message_id 消息id
     * @param string $type 消息类型
     * @return void
     */
    public function set_data_as_unread(int|array $user_ids, int $message_id, string $type){
        if(is_int($user_ids)){
            $user_ids = [$user_ids];
        }
        foreach($user_ids as $user_id){
            // 设置用户的未读消息
            Redis::sadd("message:unread:{$type}:{$user_id}", $message_id);
        }
        // 设置消息的未读用户
        Redis::sadd("message:users:{$message_id}", ...$user_ids);
    }

    /**
     * 设置消息为已读
     *
     * @param integer $user_id 会员id
     * @param integer $message_id 消息id
     * @param string $type 消息类型
     * @return void
     */
    public function set_data_as_read(int $user_id, int $message_id, string $type){
        // 从用户的未读消息中删除
        Redis::srem("message:unread:{$type}:{$user_id}", $message_id);
        // 从消息的未读用户中删除
        Redis::srem("message:users:{$message_id}", $user_id);
        // 记录消息的已读用户
        Redis::sadd("message:read:{$message_id}", $user_id);
    }

    /**
     * 检查消息是否已读
     *
     * @param int $user_id
     * @param int $message_id
     * @param string $type 消息类型
     * @return bool 是否已读, true表示已读, false表示未读
     */
    public function get_data_read_status_by_user(int $user_id, int $message_id, string $type):bool{
        return !Redis::sismember("message:unread:{$type}:{$user_id}", $message_id);
    }

    /**
     * 获取会员未读消息数量
     *
     * @param int $user_id
     * @param string $type 消息类型
     * @return int
     */
    public function get_unread_count_by_user(int $user_id, string $type):int{
        return Redis::scard("message:unread:{$type}:{$user_id}");
    }
}