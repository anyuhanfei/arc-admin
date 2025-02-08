<?php

namespace App\Repositories\Feedback;

use App\Models\Feedback\Feedbacks as Model;
use Dcat\Admin\Repositories\EloquentRepository;

/**
 * 意见反馈数据仓库
 */
class Feedbacks extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function status_array(){
        return (new $this->eloquentClass())->status_array();
    }

    public function status_color_array(){
        return (new $this->eloquentClass())->status_color_array();
    }

    public function create_data($user_id, $type, $content, $contact, $images){
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
