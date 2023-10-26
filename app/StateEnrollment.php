<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateEnrollment extends Model
{
   protected $fillable = [
     'name', 'state', 'delete_moodle'
   ];

   public function enrollments()
   {
      return$this->hasMany(Enrollment::class, 'state', 'id');
   }
}