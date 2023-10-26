<?php

namespace App;

use App\Traits\MonthScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
   use MonthScope;

   protected $table = 'departments';

    protected $fillable = [
        'name', 'state'
    ];

    /**
      * The attributes that should be cast to native types.
      *
      * @var array
    */
    protected $casts = [
       'state' => 'boolean',
    ];

    public function programs() : HasMany
    {
        return $this->hasMany(Program::class, 'department_id', 'id');
    }

    public function getStateStrAttribute()
    {
       return $this->state == 1 ? 'Activado' : 'Desactivado';
    }
}
