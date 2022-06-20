<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends \Spatie\Permission\Models\Permission
{
    use SoftDeletes, LogsActivity;

    protected static $logFillable = true;
    protected $fillable = ['name'];

    public static function rules() {
        return [
            'name' => 'required',
        ];
    }

    public static function attributes($name = null) {
        $list = [
            'name' => 'Nama',
        ];

        return !empty($name) ? $list[$name] : $list;
    }
}
