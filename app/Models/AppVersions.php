<?php
namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class AppVersions extends Model{
    use HasDateTimeFormatter;

    protected $table = 'app_versions';
    protected $guarded = [];
}