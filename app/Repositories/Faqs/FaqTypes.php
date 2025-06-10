<?php

namespace App\Repositories\Faqs;

use App\Models\Faqs\FaqTypes as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

// 常见问题类型数据仓库
class FaqTypes extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function admin_get_datas_by_name($name = ''){
        return $this->eloquentClass::where('name', 'like', "%{$name}%")->get(['id', DB::raw("name as text")]);
    }

    public function get_datas_by_publish():Collection{
        return $this->eloquentClass::with('faqs')->publish()->get();
    }
}
