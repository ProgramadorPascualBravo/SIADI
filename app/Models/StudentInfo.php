<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = 'student_info';

    protected $fillable = [
        'document',
        'plan_estudios',
        'departamento',
        'jornada',
        'codigo_matricula'
    ];

    public $timestamps = true;
}
