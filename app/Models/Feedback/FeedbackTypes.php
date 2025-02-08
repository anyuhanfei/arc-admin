<?php

namespace App\Models\Feedback;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FeedbackTypes extends Model implements Sortable{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use SortableTrait;

    protected $table = 'feedback_types';
    protected $guarded = [];

    protected $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];
}
