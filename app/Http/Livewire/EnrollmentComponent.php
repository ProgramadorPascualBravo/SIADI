<?php


namespace App\Http\Livewire;


use App\Course;
use App\Enrollment;
use App\Group;
use App\Interfaces\ModuleComponent;
use App\RolMoodle;
use App\StateEnrollment;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class EnrollmentComponent
 * @package App\Http\Livewire
 */
class EnrollmentComponent extends Component implements ModuleComponent
{
   use ClearErrorsLivewireComponent, WithPagination, FlashMessageLivewaire, LogsTrail;

   public $view = 'create';

   public $id_enrollment, $code, $rol, $email, $state, $period;

   protected $listeners = ['edit', 'showAlert'];


   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.enrollment.title'));
      return view('livewire.enrollment.enrollment-component', [
         'groups' => Group::where('state', 1)->get(),
         'roles'  => RolMoodle::where('state', 1)->select('name')->get(),
         'states'  => StateEnrollment::where('state', 1)->select(['name', 'id'])->get()
      ]);
   }
   public function store()
   {
      $this->validate([
         'code'              => 'required|exists:groups,code|unique_with:enrollments,email,period',
         'email'             => 'required|exists:students,email,state,1',
         'rol'               => 'required|exists:roles_moodle,name',
         'state'             => 'required|exists:state_enrollments,id',
         'period'            => 'required'
      ]);
      try {

         $enrollment = new Enrollment();

         $enrollment->create([
            'email'             => trim($this->email),
            'code'              => trim($this->code),
            'rol'               => trim($this->rol),
            'state'             => $this->state,
            'period'            => trim($this->period)
         ]);

         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.create'));
         $this->setLog('info', __('messages.success.create'), 'store', __('modules.enrollment.title'), [
            'create' => $enrollment
         ]);

      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.create'));
         $this->setLog('error', __('messages.errors.create'), 'store', __('modules.enrollment.title'), [
            'exception' => $queryException->getMessage()
         ]);
      }

   }

   public function edit($id)
   {
      $enrollment          = Enrollment::find($id);
      $this->id_enrollment = $enrollment->id;
      $this->email         = $enrollment->email;
      $this->code          = $enrollment->code;
      $this->rol           = $enrollment->rol;
      $this->state         = $enrollment->state;
      $this->period        = $enrollment->period;
      $this->view          = 'edit';
   }

   public function update()
   {
      $this->validate([
         'code'              => 'required|exists:groups,code',
         'email'             => 'required|exists:students,email',
         'rol'               => 'required|exists:roles_moodle,name',
         'state'             => 'required|exists:state_enrollments,id',
         'period'            => 'required'
      ]);

      try  {

         $enrollment = Enrollment::find($this->id_enrollment);

         $enrollment->update([
            'email'          => trim($this->email),
            'code'           => trim($this->code),
            'rol'            => trim($this->rol),
            'state'          => $this->state,
            'period'         => trim($this->period)
         ]);

         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.enrollment.title'), [
            'update' => $enrollment
         ]);

      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'update', __('modules.enrollment.title'), [
            'exception' => $queryException->getMessage()
         ]);
      }
   }

   public function cancel()
   {
      $this->id_enrollment    = '';
      $this->email            = '';
      $this->code             = '';
      $this->rol              = '';
      $this->state            = '';
      $this->period           = '';
      $this->view             = 'create';
      $this->hydrate();
   }

}