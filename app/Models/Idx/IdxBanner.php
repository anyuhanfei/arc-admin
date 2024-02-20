<?php

namespace App\Models\Idx;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;
/**
 * 轮播图表数据模型
 */
class IdxBanner extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'idx_banner';
    protected $guarded = [];

    /**
     * 轮播图位置集
     *
     * @return void
     */
    public function site_array(){
        return ['首页', '测试页'];
    }

    public function scopeId(Builder $builder, int $value){
        return $builder->where("id", $value);
    }

    public function scopeSite(Builder $builder, string $value){
        return $builder->where("site", $value);
    }
}
