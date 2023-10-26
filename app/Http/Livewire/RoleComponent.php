<?php


namespace App\Http\Livewire;


use App\Interfaces\ModuleComponent;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use App\User;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use Mockery\Exception;
use Spatie\Permission\Models\Role;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class RoleComponent
 * @package App\Http\Livewire
 */
class RoleComponent extends Component implements ModuleComponent
{
   use FlashMessageLivewaire, WithPagination, ClearErrorsLivewireComponent, LogsTrail;

   public $role_id, $name, $rol, $user_id;

   public $view = 'create';

   public $listeners = ['edit', 'assign'];

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.role.title'));
      return view('livewire.permission-role.role-component', [
         'roles' => Role::all(),
         'users' => User::all()
      ]);
   }

   public function store()
   {
      $this->validate([
         'name' => 'required'
      ]);
      try {
         $role = Role::create([
            'name' => $this->name
         ]);
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.create'));
         $this->setLog('info', __('messages.success.create'), 'store', __('modules.role.title'), [
            'create' => $role
         ]);
      } catch (QueryException $queryException) {
         $this->showAlert('alert-success', __('messages.errors.create'));
         $this->setLog('error', __('messages.errors.create'), 'store', __('modules.role.title'), [
             'exception' => $queryException->getMessage()
         ]);
      }
   }

   public function edit($id)
   {
      $role = Role::findById($id);
      $this->role_id    = $role->id;
      $this->name       = $role->name;
      $this->view       = 'edit';
   }

   public function update()
   {
      $role = Role::findById($this->role_id);
      try {

         $this->validate([
            'name' => 'required'
         ]);

         $role->update([
            'name' => trim($this->name)
         ]);
         $this->refreshTable();
         $this->cancel();
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.role.title'), [
             'update' => $role
         ]);
         $this->showAlert('alert-success', __('messages.success.update'));
      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'update', __('modules.role.title'), [
             'exception' => $queryException->getMessage()
         ]);
      }
   }

   public function assign($roles)
   {
      $this->validate([
         'user_id' => 'required'
      ]);
      try {
         $user = User::find($this->user_id);
         $user->syncRoles($roles);
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'assign', __('modules.role.title'), [
               'update' => $user, 'roles' => $roles
            ]);
      }catch (QueryException | Exception $exception) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'assign', __('modules.role.title'), [
             'exception' => $exception->getMessage()
         ]);
      }
   }

   public function cancel()
   {
      $this->role_id      = '';
      $this->name      = '';
      $this->view         = 'create';
      $this->hydrate();
   }


   public function change()
   {
      $this->emit('refreshTableCustom', $this->user_id);
   }
}