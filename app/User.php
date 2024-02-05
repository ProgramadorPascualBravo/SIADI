<?php

namespace App;

use App\Traits\Months;
use App\Traits\MonthScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, Notifiable, MonthScope;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'username', 'password', 'department_id', 'state', 'confirmation_code', 'document'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
      * The attributes that should be cast to native types.
      *
      * @var array
    */
    protected $casts = [
       'state' => 'boolean',
       'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function getFullNameAttribute()
    {
      return  Str::title($this->name. ' ' .$this->last_name);
    }


}
