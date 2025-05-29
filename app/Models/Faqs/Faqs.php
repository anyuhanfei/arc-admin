<?php

namespace App\Models\Faqs;

use App\Enums\StatusEnum;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// 常见问题表
class Faqs extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'faqs';
    protected $guarded = [];

    public function type(){
        return $this->hasOne(FaqTypes::class, 'id', 'type_id');
    }

    public function scopeType($query, $value){
        return $query->where('type_id', $value);
    }

    public function scopePublish($query){
        return $query->where('status', StatusEnum::NORMAL);
    }
}
