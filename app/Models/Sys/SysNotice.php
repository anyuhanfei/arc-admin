<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;

/**
 * 系统公告表数据模型
 */
class SysNotice extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'sys_notice';
    protected $guarded = [];

    // 项目中公告的类型，可选项有：
    //     单条文字:   一般用于首页轮播图下滚动播出的文字公告的使用场景
    //     多条文字:   一般用于类似消息页面的使用场景
    //     单条富文本: 一般用于首页弹出公告详情页面的使用场景
    //     多条富文本: 一般用于有公告列表，类似文章功能的使用场景
    public static string $type = "多条富文本";

    public function scopeId(Builder $builder, int|array $value){
        if(!is_array($value)){
            $value = [$value];
        }
        return $builder->whereIn("id", $value);
    }

    public function scopeTitle(Builder $builder, string $value){
        return $builder->where("title", "like", "%{$value}%");
    }
}
