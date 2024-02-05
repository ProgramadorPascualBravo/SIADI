<?php

namespace App\Http\Livewire;

use App\Department;
use App\Interfaces\ModuleComponent;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Request;
use Livewire\WithPagination;
use App\User;
use Str;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class UserComponent
 * @package App\Http\Livewire
 */
class UserComponent extends Component implements ModuleComponent
{
    use WithPagination, ClearErrorsLivewireComponent, FlashMessageLivewaire, LogsTrail;

    public $view = 'create';
    public $user_id, $name, $last_name, $username, $document, $department_id, $state, $process = false;

    protected $listeners = ['edit', 'showAlert'];

    public function render()
    {
        $this->setLog('info', __('modules.enter'), 'render', __('modules.user.title'));
        return view('livewire.user.user-component', [
            'departments'   => Department::all()
        ]);
    }

    public function store()
    {

        $this->validate([
            'name'          => 'required',
            'last_name'     => 'required',
            'username'      => 'required|email:rfc|unique:users,username',
            'document'      => 'required|unique:users,document|numeric',
            'department_id' => 'required|exists:departments,id',
            'state'         => 'required'
        ]);
       try {
           $this->process           = true;
           $user                    = new User();
           $user->create([
               'name'               => trim($this->name),
               'last_name'          => trim($this->last_name),
               'username'           => trim($this->username),
               'document'           => trim($this->document),
               'department_id'      => trim($this->department_id),
               'password'           => Hash::make(trim($this->document)),
               'confirmation_code'  => Str::random(60),
               'state'              => trim($this->state)
           ]);
           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.create'));
           $this->setLog('info', __('messages.success.create'), 'store', __('modules.user.title'), [
                 'create' => $user
           ]);
       } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.errors.create'));
           $this->setLog('error', __('messages.errors.create'), 'store', __('modules.user.title'), [
                 'exception' => $queryException->getMessage()
              ]);

       }

    }

    public function edit($id)
    {
        $user                   = User::find($id);
        $this->user_id          = $user->id;
        $this->name             = $user->name;
        $this->last_name        = $user->last_name;
        $this->username         = $user->username;
        $this->document         = $user->document;
        $this->department_id    = $user->department_id;
        $this->state            = $user->state;
        $this->view             = 'edit';

    }

    public function update()
    {
        $this->validate([
            'name'          => 'required',
            'last_name'     => 'required',
            'document'      => 'required|numeric',
            'department_id' => 'required',
            'state'         => 'required',
        ]);

        try {
           $user = User::findOrFail($this->user_id);
           $user->update([
               'name'          => trim($this->name),
               'last_name'     => trim($this->last_name),
               'department_id' => trim($this->department_id),
               'document'      => trim($this->document),
               'state'         => trim($this->state)
           ]);
           $this->cancel();
           $this->refreshTable();
           $this->showAlert('alert-success', __('messages.success.update'));
           $this->setLog('info', __('messages.success.update'), 'update', __('modules.user.title'), [
              'update' => $user
           ]);
        } catch (QueryException $queryException) {
           $this->showAlert('alert-error', __('messages.errors.update'));
           $this->setLog('info', __('messages.errors.update'), 'update', __('modules.user.title'), [
              'exception' => $queryException->getMessage()
           ]);
        }

    }

    public function cancel()
    {
        $this->user_id          = '';
        $this->name             = '';
        $this->last_name        = '';
        $this->username         = '';
        $this->document         = '';
        $this->department_id    = '';
        $this->password         = '';
        $this->state            = '';
        $this->view             = 'create';
        $this->hydrate();
    }

}
