<?php

namespace App;

use App\Traits\MonthScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
   use MonthScope;

   protected $table = 'courses';

    protected $fillable = [
      'code', 'name', 'program_id', 'state'
    ];

    public function program() : BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function groups() : HasMany
    {
        return $this->hasMany(Group::class, 'course_id', 'id');
    }
}
