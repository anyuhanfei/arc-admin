<?php
namespace App\Repositories;

use App\Models\AppVersions as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppVersions extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function get_latest_version(){
        return $this->eloquentClass::orderBy("version", "desc")->first();
    }
}