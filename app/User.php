<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, LogsActivity;

    protected $guard_name = 'web';
    protected static $logFillable = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'photo', 'birth_place', 'birth_date', 'bio', 'province_id',
        'regency_id', 'district_id', 'village_id', 'address', 'expertise', 'active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function rules($action = null) {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => $action == 'create' ? 'required' : '',
            'photo' => $action == 'create' ? 'required' : '',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'bio' => 'required',
            'province_id' => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'address' => 'required',
            'expertise' => 'required',
            'active' => 'required',
        ];
    }

    public static function attributes($name = null) {
        $list = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'photo' => 'Foto',
            'birth_place' => 'Tempat Lahir',
            'birth_date' => 'Tanggal Lahir',
            'bio' => 'Bio',
            'province_id' => 'Provinsi',
            'regency_id' => 'Kota/Kab',
            'district_id' => 'Kecamatan',
            'village_id' => 'Kelurahan/Desa',
            'address' => 'Alamat',
            'expertise' => 'Keahlian',
            'active' => 'Aktif',

            'roles' => 'Roles',
            'age' => 'Usia',
        ];

        return !empty($name) ? $list[$name] : $list;
    }

    public function assignmentUser()
    {
        return $this->hasMany(AssignmentUser::class);
    }

    public function birthplace()
    {
        return $this->belongsTo(Regency::class, 'birth_place', 'id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
