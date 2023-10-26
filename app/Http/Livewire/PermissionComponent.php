<?php
namespace App\Http\Livewire;


use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use PHPUnit\Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class PermissionComponent
 * @package App\Http\Livewire
 */
class PermissionComponent extends Component
{
   use WithPagination, FlashMessageLivewaire, ClearErrorsLivewireComponent, LogsTrail;

   public $view = 'create';

   public $listeners = ['edit', 'assign'];

   public $permission_id, $name, $rol_id;

   public function render()
   {;
      $this->setLog('info', __('modules.enter'), 'render', __('modules.permission.title'));
      return view('livewire.permission-role.permission-component', [
         'roles' => Role::all(),
         'permissions' => Permission::all()
      ]);
   }

   public function store()
   {
      $this->validate([
         'name' => 'required'
      ]);
      try {
         $permission = Permission::create([
            'name' => $this->name
         ]);
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.create'));
         $this->setLog('info', __('messages.success.create'), 'store', __('modules.permission.title'), [
             'create' => $permission
         ]);
      } catch (QueryException $exception) {
         $this->showAlert('alert-success', __('messages.errors.create'));
         $this->setLog('error', __('messages.errors.create'), 'store', __('modules.permission.title'), [
             'exception' => $exception->getMessage()
         ]);
      }
   }
   public function update()
   {
      $permission = Permission::findById($this->permission_id);
      try {

         $this->validate([
            'name' => 'required'
         ]);

         $permission->update([
            'name' => trim($this->name)
         ]);
         $this->refreshTable();
         $this->cancel();
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.permission.title'), [
            'update' => $permission
         ]);
      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'update', __('modules.permission.title'), [
             'exception' => $queryException->getMessage()
         ]);

      }
   }

   public function assign($permissions)
   {

      $this->validate([
         'rol_id' => 'required'
      ]);

      try {
         $rol  = Role::find($this->rol_id);
         $rol->syncPermissions($permissions);
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'assign', __('modules.permission.title'), [
            'update' => $rol
         ]);
      } catch (Exception $exception) {
         $this->showAlert('alert-success', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'assign', __('modules.permission.title'), [
             'exception' => $exception->getMessage()
         ]);
      }

   }

   public function edit($id)
   {
      $permission             = Permission::findById($id);

      $this->permission_id    = $permission->id;
      $this->name             = $permission->name;

      $this->view             = 'edit';
   }

   public function change()
   {
      $this->emit('refreshTableCustom', $this->rol_id);
   }

   private function cancel()
   {
      $this->permission_id = '';
      $this->rol_id        = '';
      $this->name          = '';
      $this->hydrate();
   }
}