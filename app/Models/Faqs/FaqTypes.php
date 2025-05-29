<?php

namespace App\Models\Faqs;

use App\Enums\StatusEnum;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// 常见问题类型表
class FaqTypes extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'faq_types';
    protected $guarded = [];

    public function faqs(){
        return $this->hasMany(Faqs::class, 'type_id', 'id');
    }

    public function scopePublish($query){
        return $query->where('status', StatusEnum::NORMAL);
    }
}
