<?php
namespace App\Repositories;

use App\Models\AppVersions as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class AppVersions extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public function get_latest_version():?EloquentModel{
        return $this->eloquentClass::orderBy("version", "desc")->first();
    }
}