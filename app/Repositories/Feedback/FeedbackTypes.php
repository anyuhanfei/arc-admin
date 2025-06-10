<?php

namespace App\Repositories\Feedback;

use App\Models\Feedback\FeedbackTypes as Model;
use Dcat\Admin\Repositories\EloquentRepository;

/**
 * 意见反馈类型表数据仓库
 */
class FeedbackTypes extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 获取类型名称列表
     *
     * @return void
     */
    public function get_names():array{
        return $this->eloquentClass::pluck("name")->toArray();
    }
}
