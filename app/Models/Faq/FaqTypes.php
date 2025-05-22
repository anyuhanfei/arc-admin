<?php

namespace App\Models\Faq;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FaqTypes extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'faq_types';
    
}
