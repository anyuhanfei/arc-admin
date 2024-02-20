<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;

/**
 * 系统配置表数据模型
 */
class SysSetting extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'sys_setting';
    protected $guarded = [];
    protected $primaryKey = 'key';

    public function parent(){
        return $this->hasOne(SysSetting::class, 'id', 'parent_id');
    }

    public function children(){
        return $this->hasMany(SysSetting::class, 'parent_id', 'id');
    }

    public function scopeParentId(Builder $builder, int $value){
        return $builder->where("parent_id", $value);
    }

    public function scopeKey(Builder $builder, string $value){
        return $builder->where('key', $value);
    }
}
