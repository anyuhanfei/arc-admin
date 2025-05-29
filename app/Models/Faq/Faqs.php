<?php

namespace App\Models\Faq;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// 常见问题表
class Faqs extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'faqs';
    protected $guarded = [];
}
