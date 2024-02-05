<?php

namespace App;

use App\Traits\MonthScope;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
   use MonthScope;

   protected $table = 'programs';

    protected $fillable = [
        'name', 'state', 'department_id', 'faculty', 'code'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function courses()
    {
       return $this->hasMany(Course::class, 'program_id', 'id');
    }
}
