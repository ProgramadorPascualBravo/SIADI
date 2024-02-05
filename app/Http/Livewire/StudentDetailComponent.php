<?php


namespace App\Http\Livewire;


use App\Student;
use App\StudentDBMoodle;
use App\Traits\LogsTrail;
use Livewire\Component;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class StudentDetailComponent
 * @package App\Http\Livewire
 */
class StudentDetailComponent extends Component
{
   use LogsTrail;

   public $enrollments, $student;

   function mount(Student $student)
   {
      $this->student = $student;
      $this->enrollments = $this->student->enrollments;
   }

   function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.moodle.detail'), [
         'user' => $this->student
      ]);
      return view('livewire.student.details-component');
   }
}