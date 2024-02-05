<?php

namespace App\Http\Livewire;

use App\Course;
use App\Interfaces\ModuleComponent;
use App\Program;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class CourseComponent
 * @package App\Http\Livewire
 */
class CourseComponent extends Component implements ModuleComponent
{
    use WithPagination, ClearErrorsLivewireComponent, FlashMessageLivewaire, LogsTrail;

    public $view = 'create';

    public $course_id, $name, $code, $program_id, $state, $process, $group = 0;

   protected $listeners = ['edit', 'showAlert'];

   public function render()
    {
       $this->setLog('info', __('modules.enter'), 'render', __('modules.course.title'));
       return view('livewire.course.course-component',
            [
                'programs'   => Program::where('state', 1)->get()
            ]
        );
    }

    public function store()
    {
        $this->validate([
            'name'              => 'required',
            'code'              => 'required|unique:courses,code|unique_with:courses,id',
            'program_id'        => 'required|exists:programs,id',
            'state'             => 'required|numeric'
        ]);
        try {
            $course = new Course();

            $course->create([
               'name'              => trim($this->name),
               'code'              => trim($this->code),
               'program_id'        => trim($this->program_id),
               'state'             => trim($this->state)
            ]);

           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.create'));
           $this->setLog('info', __('messages.success.create'), 'store', __('modules.course.title'), [
              'create' => $course
           ]);

        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.errors.create'));
           $this->setLog('error', __('messages.errors.create'), 'store', __('modules.course.title'), [
              'exception' => $queryException->getMessage()
           ]);
        }

    }

    public function edit($id)
    {
        $course             = Course::find($id);
        $this->course_id    = $course->id;
        $this->name         = $course->name;
        $this->code         = $course->code;
        $this->program_id   = $course->program_id;
        $this->state        = $course->state;
        $this->group        = $course->groups->count();
        $this->view         = 'edit';
    }

    public function update()
    {
        $this->validate([
            'name'              => 'required',
            'code'              => 'required|exists:courses,code',
            'program_id'        => 'required|exists:programs,id',
            'state'             => 'required|numeric'
        ]);

        try  {

           $course = Course::findOrFail($this->course_id);

           $course->update([
               'name'              => trim($this->name),
               'code'              => trim($this->code),
               'program_id'        => trim($this->program_id),
               'state'             => trim($this->state)
           ]);

           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.update'));
           $this->setLog('info', __('messages.success.update'), 'update', __('modules.course.title'), [
              'update' => $course
           ]);
        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.error.update'));
           $this->setLog('error', __('messages.errors.update'), 'store', __('modules.course.title'), [
              'exception' => $queryException->getMessage()
           ]);
        }
    }

    public function cancel()
    {
        $this->course_id    = '';
        $this->name         = '';
        $this->code         = '';
        $this->state        = '';
        $this->program_id   = '';
        $this->moodle_id    = '';
        $this->view         = 'create';
        $this->hydrate();
    }

}
