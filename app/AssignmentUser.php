<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class AssignmentUser extends Model
{
    use SoftDeletes, LogsActivity;

	protected $table = 'assignment_user';

    protected static $logFillable = true;
    protected $fillable = ['assignment_id', 'user_id', 'served_as', 'workload', 'status_id', 'info'];

    public static function rules() {
        return [
            'assignment_id' => 'required',
            'user_id' => 'required',
            'served_as' => 'required',
            'workload' => 'required',
            'status_id' => 'required',
            'info' => 'required',
        ];
    }

    public static function attributes($name = null) {
        $list = [
            'assignment_id' => 'ID',
            'user_id' => 'Nama',
            'served_as' => 'Sebagai',
            'workload' => 'Beban Kerja',
            'status_id' => 'Status',
            'info' => 'Ket',
        ];

        return !empty($name) ? $list[$name] : $list;
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignmentAs()
    {
        return $this->belongsTo(AssignmentAs::class, 'served_as', 'id');
    }

    public function assignmentStatus()
    {
        return $this->belongsTo(AssignmentStatus::class, 'status_id', 'id');
    }
}
