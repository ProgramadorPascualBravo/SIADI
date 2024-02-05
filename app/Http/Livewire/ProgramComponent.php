<?php

namespace App\Http\Livewire;

use App\Department;
use App\Program;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class ProgramComponent
 * @package App\Http\Livewire
 */
class ProgramComponent extends Component
{

    use WithPagination, ClearErrorsLivewireComponent, FlashMessageLivewaire, LogsTrail;

    public $view = 'create';

    public $program_id, $name, $code, $department_id, $faculty, $state;

    protected $listeners = ['edit', 'showAlert'];

    public function render()
    {
       $this->setLog('info', __('modules.enter'), 'render', __('modules.program.title'));
       return view('livewire.program.program-component', [
            'departments'   => Department::where('state', 1)->get()
        ]);
    }

    public function store()
    {
        $this->validate([
            'name'              => 'required|unique:programs,name',
            'code'              => 'required|numeric',
            'department_id'     => 'required|exists:departments,id',
            'faculty'           => 'required',
            'state'             => 'required'
        ]);

        try {

           $program = new Program();

           $program->create([
               'name'              => trim($this->name),
               'code'              => trim($this->code),
               'faculty'           => trim($this->faculty),
               'department_id'     => $this->department_id,
               'state'             => $this->state
           ]);
           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.create'));
           $this->setLog('info', __('messages.success.create'), 'store', __('modules.program.title'), [
               'create' => $program
           ]);
        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.errors.create'));
           $this->setLog('error', __('messages.errors.create'), 'store', __('modules.program.title'), [
               'exception' => $queryException->getMessage()
           ]);

        }
    }

    public function edit($id)
    {
        $program                = Program::find($id);
        $this->program_id       = $program->id;
        $this->department_id    = $program->department_id;
        $this->faculty          = $program->faculty;
        $this->name             = $program->name;
        $this->code             = $program->code;
        $this->state            = $program->state;
        $this->view             = 'edit';
    }

    public function update()
    {
        $this->validate([
            'name'              => 'required',
            'code'              => 'required|numeric',
            'department_id'     => 'required|exists:departments,id',
            'faculty'           => 'required',
            'state'             => 'required'
        ]);

        try {
           $program = Program::findOrFail($this->program_id);
           $program->update([
              'name'           => trim($this->name),
              'code'           => trim($this->code),
              'faculty'        => trim($this->faculty),
              'department_id'  => $this->department_id,
              'state'          => $this->state,
           ]);
           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.update'));
        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.error.update'));        }
    }

    public function cancel()
    {
        $this->program_id       = '';
        $this->name             = '';
        $this->state            = '';
        $this->faculty          = '';
        $this->department_id    = '';
        $this->code             = '';
        $this->view             = 'create';
        $this->hydrate();
    }

}
