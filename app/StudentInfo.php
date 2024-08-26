<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
   protected $table = 'student_info';


   public $timestamps = false;

   protected $fillable = [
      'document',
      'plan_estudios',
      'departamento',
      'jornada',
   ];
}