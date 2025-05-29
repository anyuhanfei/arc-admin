<?php

namespace App\Models\Feedback;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// 用户反馈表
class Feedbacks extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'feedbacks';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\Users\Users', 'user_id');
    }
}
