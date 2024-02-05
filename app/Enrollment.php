<?php

namespace App;

use App\Traits\MonthScope;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Manager;

class Enrollment extends Model
{
   use MonthScope;

   protected $table = 'enrollments';

    protected $fillable = [
      'email', 'code', 'rol', 'state', 'period'
    ];

    public function group() : BelongsTo
    {
       return $this->belongsTo(Group::class, 'code', 'code');
    }

    public function user() : BelongsTo
    {
       return $this->belongsTo(Student::class, 'email', 'email');
    }

    public function state_enrollment() : BelongsTo
    {
       return $this->belongsTo(StateEnrollment::class, 'state', 'id');
    }

    public function enrollment_moodle() : HasOne
    {
       return $this->hasOne(EnrollmentMoodle::class, 'enrollment_id', 'id');
    }

   public static function lastEntry($code, $email)
   {
      return DB::connection('mysql_moodle')
         ->select("SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess),'%d-%m-%Y') AS ultimoCur
            FROM mdl_user u, mdl_role_assignments ra, mdl_context c, mdl_course co, mdl_user_lastaccess la
            WHERE u.id=ra.userid AND ra.contextid = c.id AND c.instanceid=co.id
            AND u.id=la.userid AND co.id=la.courseid
            AND u.username='$email' AND co.idnumber='$code'");
   }

   /* public function course() : HasOneThrough
    {
        return $this->hasOneThrough(Course::class, Group::class, 'code', 'course_id', 'code', 'id');

    }

    public function program() : HasOneThrough
    {
        return $this->hasOneThrough(Program::class, Course::class, 'course_id', 'program_id', 'id', 'id');

    }*/
}
