<?php

namespace App;

use App\GroupDBMoodle;
use App\Traits\MonthScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Group extends Model
{
   use MonthScope;

      protected $table = 'groups';

    protected $fillable = [
      'name', 'code', 'course_id','course_url', 'course_state', 'state', 'period', 'short_name'
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function enrollments() : HasMany
    {
       return $this->hasMany(Enrollment::class, 'code', 'code');
    }

    public function group_external() : HasOne
    {
      return $this->hasOne(GroupDBMoodle::class, 'idnumber', 'code');
    }

   public function enrollments_moodle()
   {
      return $this->hasMany(EnrollmentMoodle::class, 'code', 'code');
   }
}
