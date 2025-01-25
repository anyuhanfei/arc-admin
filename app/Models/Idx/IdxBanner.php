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

    /**
     * 链接类型(新增类型后需要对应添加数据库表字段中的枚举值)
     *   nothing: 不设置链接
     *   external_link：外链，直接输入网址
     *   internal_link：内链，内链列表需要使用到 internal_link_array 方法
     *   article_id：文章，选择文章（实际项目中如有其他类型的跳转可模仿）
     *
     * @return void
     */
    public function link_type_array(){
        return ['nothing'=> '不设置', 'external_link'=> '外链', 'internal_link'=> '内链', 'article_id'=> '文章'];
    }

    /**
     * 内链列表，实际项目中把可跳转的前端页面跳转链接添加到这里
     *
     * @return void
     */
    public function internal_link_array(){
        return [
            '/page/page/index'=> '首页',
        ];
    }

    public function scopeId(Builder $builder, int $value){
        return $builder->where("id", $value);
    }

    public function scopeSite(Builder $builder, string $value){
        return $builder->where("site", $value);
    }
}
