<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes, LogsActivity;

    protected static $logFillable = true;
    protected $fillable = ['name', 'guard_name'];

    public static function rules() {
        return [
            'name' => 'required',
        ];
    }

    public static function attributes($name = null) {
        $list = [
            'name' => 'Nama',

            'permissions' => 'Permissions',
        ];

        return !empty($name) ? $list[$name] : $list;
    }
}
