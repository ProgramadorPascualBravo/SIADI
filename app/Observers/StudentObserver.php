<?php

namespace App\Observers;

use App\Enrollment;
use App\Student;
use App\StudentDBMoodle;

/**
 * Componente https://laravel.com/docs/7.x/eloquent#observers
 * Class StudentObserver
 * @package App\Observers
 */
class StudentObserver
{

    public $beforeCommit = true;


    /**
     * Handle the student "created" event.
     *
     * @param  \App\Student  $student
     * @return void
     */
    public function created(Student $student)
    {
        //
    }

    /**
     * Handle the student "updated" event.
     *
     * @param  \App\Student  $student
     * @return void
     */
    public function updated(Student $student)
    {
       /**
        if ($student->isDirty('email')) {
           Enrollment::where('email', $student->getOriginal('email'))->update(
             [
                'email' => $student->email
             ]
           );
       }
        **/
        if ($student->isDirty('state')) {
            StudentDBMoodle::where('username', $student->email)->update(['suspended' => !$student->state]);
        }
    }

    /**
     * Handle the student "deleted" event.
     *
     * @param  \App\Student  $student
     * @return void
     */
    public function deleted(Student $student)
    {
    }

    /**
     * Handle the student "restored" event.
     *
     * @param  \App\Student  $student
     * @return void
     */
    public function restored(Student $student)
    {
        //
    }

    /**
     * Handle the student "force deleted" event.
     *
     * @param  \App\Student  $student
     * @return void
     */
    public function forceDeleted(Student $student)
    {
        //
    }
}
