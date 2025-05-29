<?php

namespace App\Repositories\Faqs;

use App\Models\Faqs\Faqs as Model;
use Dcat\Admin\Repositories\EloquentRepository;

// 常见问题数据仓库
class Faqs extends EloquentRepository{
    protected $eloquentClass = Model::class;
}
