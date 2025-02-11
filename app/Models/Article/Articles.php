<?php

namespace App\Models\Article;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;

/**
 * 文章表数据模型
 */
class Articles extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    public function status_array(){
        return ['normal'=> '发布', 'hidden'=> '隐藏'];
    }

    public function status_color_array(){
        return ['normal'=> 'success', 'hidden'=> 'danger'];
    }

    protected $table = 'articles';
    protected $guarded = [];

    /**
     * 分类id
     *
     * @return void
     */
    public function category(){
        return $this->hasOne(ArticleCategories::class, 'id', 'category_id')->withTrashed();
    }

    public function scopeId(Builder $builder, int $value){
        return $builder->where('id', $value);
    }

    public function scopeCategoryId(Builder $builder, int $value){
        return $builder->where('category_id', $value);
    }

    public function scopeTitle(Builder $builder, string $value){
        return $builder->where("title", 'like', '%'.$value.'%');
    }

    public function scopeStatus(Builder $builder, string $value){
        return $builder->where('status', $value);
    }
}
