<?php

namespace App\Http\Livewire;

use App\Department;
use App\Interfaces\ModuleComponent;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class DepartmentComponent
 * @package App\Http\Livewire
 */
class DepartmentComponent extends Component implements ModuleComponent
{
    use ClearErrorsLivewireComponent, WithPagination, FlashMessageLivewaire, LogsTrail;

    public $view = 'create';

    public $name, $department_id, $state, $process;

    protected $listeners = ['edit', 'showAlert'];

    public function render()
    {
       $this->setLog('info', __('modules.enter'), 'render', __('modules.category.title'));
       return view('livewire.department.department-component');
    }

    public function store()
    {
        $this->validate([
           'name'    => 'required|unique:departments,name',
           'state'   => 'required'
        ]);
        try  {

           $department = new Department();

           $department->create([
              'name'          => trim($this->name)
           ]);

           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.create'));
           $this->setLog('info', __('messages.success.create'), 'store', __('modules.category.title'), [
               'create' => $department
           ]);
        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.errors.create'));
           $this->setLog('error', __('messages.errors.create'), 'store', __('modules.category.title'), [
               'exception' => $queryException->getMessage()
           ]);
        }
    }


    public function edit($id)
    {
        $department             = Department::find($id);
        $this->name             = $department->name;
        $this->department_id    = $department->id;
        $this->state            = $department->state;
        $this->view             = 'edit';
    }

    public function update()
    {
        $this->validate([
            'name'          => 'required',
            'state'         => 'required'
        ]);
       try {
            $department = Department::findOrFail($this->department_id);
            $department->update([
               'name'        => trim($this->name),
               'state'       => $this->state
            ]);

            $this->cancel();
            $this->refreshTable();
            $this->showAlert('alert-success', __('messages.success.update'));
            $this->setLog('info', __('messages.success.update'), 'update', __('modules.category.title'), [
                'update' => $department
            ]);
       } catch (QueryException $queryException) {
            $this->showAlert('alert-error', __('messages.errors.update'));
            $this->setLog('error', __('messages.errors.update'), 'update', __('modules.category.title'), [
               'exception' => $queryException->getMessage()
            ]);
       }
    }

    public function cancel()
    {
        $this->department_id    = '';
        $this->name             = '';
        $this->view             = 'create';
        $this->state            = '';
        $this->hydrate();
    }

}
