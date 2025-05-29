<?php

namespace App\Repositories\Feedback;

use App\Models\Feedback\Feedbacks as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 意见反馈数据仓库
 */
class Feedbacks extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 创建意见反馈
     *
     * @param [type] $user_id
     * @param [type] $type
     * @param [type] $content
     * @param [type] $contact
     * @param [type] $images
     * @return EloquentModel
     */
    public function create_data($user_id, $type, $content, $contact, $images):EloquentModel{
        $data = [
            'user_id' => $user_id,
            'type' => $type,
            'content' => $content,
            'contact' => $contact,
            'images' => json_encode($images),
            'status' => 'untreated',
        ];
        return $this->eloquentClass::create($data);
    }
}
