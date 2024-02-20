<?php

namespace App\Models\Log;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Users\Users;
use App\Models\BaseFilter;

/**
 * 系统消息表数据模型
 */
class LogSysMessage extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'log_sys_message';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, "id", "user_id");
    }

    public function scopeId(Builder $builder, int $value){
        return $builder->where("id", $value);
    }

    public function scopeUserIds(Builder $builder, int $value){
        return $builder->where("user_ids", 0)->orWhere(function(Builder $query) use($value){
            $query->whereRaw("FIND_IN_SET({$value}, user_ids)");
        });
    }
}
