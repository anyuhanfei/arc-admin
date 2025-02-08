<?php

namespace App\Models\Feedback;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'feedbacks';
    protected $guarded = [];

    public function status_array(){
        return ['untreated'=> '未处理', 'shelved'=> '搁置', 'processed'=> '已处理', 'rejected'=> '拒绝处理'];
    }

    public function status_color_array(){
        return ['untreated'=> 'danger','shelved'=> 'warning', 'processed'=> 'success','rejected'=> 'danger'];
    }

    public function user(){
        return $this->belongsTo('App\Models\Users\Users', 'user_id');
    }
}
