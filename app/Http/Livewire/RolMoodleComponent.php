<?php


namespace App\Http\Livewire;


use App\Interfaces\ModuleComponent;
use App\RolMoodle;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class RolMoodleComponent
 * @package App\Http\Livewire
 */
class RolMoodleComponent extends Component implements ModuleComponent
{
   use ClearErrorsLivewireComponent, WithPagination, FlashMessageLivewaire, LogsTrail;

   public $view = 'create';

   public $id_rol_moodle, $name, $state;

   protected $listeners = ['edit', 'showAlert'];

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.role-moodle.title'));
      return view('livewire.rol_moodle.rol-moodle-component');
   }

   public function store()
   {
      $this->validate([
         'name'      => 'required|unique:roles_moodle,name',
         'state'     => 'required'
      ]);

      try {


         $rolMoodle = new RolMoodle();

         $rolMoodle->create([
            'name' => trim($this->name),
            'state'  => $this->state
         ]);
         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.create'));
         $this->setLog('info', __('messages.success.create'), 'store', __('modules.role-moodle.title'), [
             'create' => $rolMoodle
         ]);
      }catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.create'));
         $this->setLog('error', __('messages.errors.create'), 'store', __('modules.role-moodle.title'), [
            'exception' => $queryException->getMessage()
         ]);
      }

   }


   public function edit($id)
   {
      $rolMoodle             = RolMoodle::find($id);
      $this->name             = $rolMoodle->name;
      $this->id_rol_moodle    = $rolMoodle->id;
      $this->state            = $rolMoodle->state;
      $this->view             = 'edit';
   }

   public function update()
   {
      $this->validate([
         'name'          => 'required',
         'state'         => 'required'
      ]);
      try {
         $this->process   = true;
         $rolMoodle = RolMoodle::findOrFail($this->id_rol_moodle);
         /*$rolMoodle->update([
            'name'        => trim($this->name),
            'state'       => trim($this->state)
         ]);*/
          $rolMoodle->name = $this->name;
          $rolMoodle->state = $this->state;
          $rolMoodle->save();

        // dd("hizo el update", $this->state, $rolMoodle);
         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.role-moodle.title'), [
             'update' => $rolMoodle
         ]);
      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('info', __('messages.errors.update'), 'update', __('modules.role-moodle.title'), [
             'exception' => $queryException->getMessage()
         ]);
      }
   }

   public function cancel()
   {
      $this->id_rol_moodle    = '';
      $this->name             = '';
      $this->state            = '';
      $this->view             = 'create';
      $this->hydrate();
   }

}
