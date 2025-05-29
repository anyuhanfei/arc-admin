<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;
/**
 * 轮播图表数据模型
 */
class SysBanners extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'sys_banners';
    protected $guarded = [];

    public function scopeId(Builder $builder, int $value){
        return $builder->where("id", $value);
    }

    public function scopeSite(Builder $builder, string $value){
        return $builder->where("site", $value);
    }
}
