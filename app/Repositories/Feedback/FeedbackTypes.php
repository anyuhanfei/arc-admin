<?php

namespace App\Repositories\Feedback;

use App\Models\Feedback\FeedbackTypes as Model;
use Dcat\Admin\Repositories\EloquentRepository;

/**
 * 意见反馈类型表数据仓库
 */
class FeedbackTypes extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function get_names(){
        return $this->eloquentClass::pluck("name");
    }
}
