<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolMoodle extends Model
{
    protected $table = 'roles_moodle';

    protected $fillable = ['name'];

    public function enrollments()
    {
       return $this->hasMany(Enrollment::class, 'rol', 'name');
    }
}
