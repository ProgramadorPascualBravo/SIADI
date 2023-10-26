<?php


namespace App\Http\Livewire;


use App\Course;
use App\Traits\LogsTrail;
use Livewire\Component;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class CourseDetailComponent
 * @package App\Http\Livewire
 */
class CourseDetailComponent extends Component
{
   use LogsTrail;

   public $course;

   public function mount($course)
   {
      $this->course  = $course;
   }

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.course.detail'));
      return view('livewire.course.details-component');
   }
}