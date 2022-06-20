<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Assignment extends Model
{
    use SoftDeletes, LogsActivity;

    protected static $logFillable = true;
    protected $fillable = ['nama', 'start_datetime', 'end_datetime', 'location'];

    public static function rules() {
        return [
            'nama' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'location' => 'required'
        ];
    }

    public static function attributes($name = null) {
        $list = [
            'name' => 'Nama Kegiatan',
            'start_datetime' => 'Waktu Awal',
            'end_datetime' => 'Waktu Akhir',
            'location' => 'Lokasi'
        ];

        return !empty($name) ? $list[$name] : $list;
    }

    public function assignmentUser()
    {
        return $this->hasMany(AssignmentUser::class, 'assignment_id', 'id');
    }
}
