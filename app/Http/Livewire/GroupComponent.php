<?php

namespace App\Http\Livewire;

use App\Course;
use App\Group;
use App\Interfaces\ModuleComponent;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class GroupComponent
 * @package App\Http\Livewire
 */
class GroupComponent extends Component implements ModuleComponent
{

    use WithPagination, ClearErrorsLivewireComponent, FlashMessageLivewaire, LogsTrail;


    public $view = 'create';

    public $name, $code, $course_id, $state, $group_id, $process, $enrollment = 0;

   protected $listeners = ['errorNotUnique', 'edit', 'showAlert'];

   public function render()
    {
       $this->setLog('info', __('modules.enter'), 'render', __('modules.course.title'));
       return view('livewire.group.group-component', [
            'courses'   => Course::where('state', 1)->get()
        ]);
    }

    public function store()
    {
        $this->validate([
            'name'      => 'required',
            'course_id' => 'required|exists:courses,id',
            'state'     => 'required'
        ]);
        try {

            $course = Course::findOrFail($this->course_id);

            $course->groups()->create([
               'name'      => trim($this->name),
               'code'      => trim($course->code . $this->name),
               'short_name'=> trim($course->code . $this->name),
               'state'     => $this->state
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
        $group              = Group::find($id);

        $this->group_id     = $group->id;
        $this->name         = $group->name;
        $this->course_id    = $group->course_id;
        $this->state        = $group->state;
        $this->enrollment   = $group->enrollments->count();
        $this->view         = 'edit';

    }

    public function update()
    {
        $this->validate([
            'name'      => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        try {
           $this->process  = true;
           $group          = Group::findOrFail($this->group_id);
           $course         = Course::findOrFail($this->course_id);

           $group->update([
               'name'      => trim($this->name),
               'code'      => trim($course->code . $this->name),
               'course_id' => trim($course->id),
               'short_name'=> trim($course->code . $this->name),
               'state'     => $this->state

           ]);

           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.update'));
           $this->setLog('info', __('messages.success.update'), 'update', __('modules.course.title'), [
               'update'  => $group
           ]);

        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.error.update'));
           $this->setLog('error', __('messages.errors.update'), 'update', __('modules.course.title'), [
               'exception' => $queryException->getMessage()
           ]);
        }
    }

    public function cancel()
    {
        $this->group_id     = '';
        $this->state        = '';
        $this->code         = '';
        $this->name         = '';
        $this->course_id    = '';
        $this->view         = 'create';
        $this->hydrate();

    }

}
