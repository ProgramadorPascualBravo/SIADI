<?php


namespace App\Http\Livewire;


use App\Department;
use App\Interfaces\ModuleComponent;
use App\Student;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class StudentComponent
 * @package App\Http\Livewire
 */
class StudentComponent extends Component implements ModuleComponent
{
   use WithPagination, ClearErrorsLivewireComponent, FlashMessageLivewaire, LogsTrail;

   public $view = 'create';

   public $user_id, $name, $last_name, $email, $document, $state, $block, $process = false, $enrollment = 0;

   protected $listeners = ['edit', 'showAlert'];

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.moodle.title'));
      return view('livewire.student.student-component', [
         'departments'   => Department::all()
      ]);
   }

   public function validationAttributes()
   {
      return [
         'name' => 'Nombres',
         'last_name' => 'Apellidos',
         'email' => 'Correo Institucional',
         'document' => 'Documento De Identidad',
         'state' => 'Estado',
      ];
   }

   public function validationRules()
   {
      $rules = [
         'name'          => 'required',
         'last_name'     => 'required',
         'document'      => 'required|unique:students,document|numeric',
         'state'         => 'required',
      ];

      $rules['email'] = [
         'required',
         'email:rfc',
         'unique:students,email',
         'unique:students,document',
         function($attribute, $value, $fail) {
            $cleanValue = str_replace(' ', '', $value); 
            $cleanValue = preg_replace('/[^A-Za-z0-9@._\-]/', '', $value); // Removes special chars.
            $cleanValue = strtolower($cleanValue);

            if ($value !== $cleanValue) {
               $fail(__('validation.moodle_username'));
            }
         },
      ];
      return $rules;
   }

   public function store()
   {
      $this->validate($this->validationRules());
      try {
         $student = new Student();

         $student->create([
            'name'          => trim($this->name),
            'last_name'     => trim($this->last_name),
            'email'         => trim($this->email),
            'document'      => trim($this->document),
            'password'      => md5(trim($this->document)),
            'state'         => trim($this->state)

         ]);
         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.create'));
         $this->setLog('info', __('messages.success.create'), 'store', __('modules.moodle.title'), [
            'create' => $student
         ]);
      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.create'));
         $this->setLog('error', __('messages.errors.create'), 'store', __('modules.moodle.title'), [
            'exception' => $queryException->getMessage()
         ]);
      }

   }

   public function edit($id)
   {
      $student             = Student::find($id);
      $this->user_id       = $student->id;
      $this->name          = $student->name;
      $this->last_name     = $student->last_name;
      $this->email         = $student->email;
      $this->document      = $student->document;
      $this->state         = $student->state;
      $this->enrollment    = $student->enrollments->count();
      $this->view          = 'edit';
   }

   public function update()
   {
      $this->validate([
         'name'          => 'required',
         'last_name'     => 'required',
         'email'         => 'required|email:rfc',
         'document'      => 'required',
         'state'         => 'required',
      ]);

      try {
         $student = Student::findOrFail($this->user_id);
         $student->update([
            'name'          => trim($this->name),
            'last_name'     => trim($this->last_name),
            //'email'         => trim($this->email),
            'document'      => trim($this->document),
            'state'         => trim($this->state),
         ]);
         $this->cancel();
         $this->refreshTable();
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.moodle.title'), [
            'update' => $student
         ]);
      } catch (QueryException $queryException) {
         $this->showAlert('alert-error', __('messages.errors.update'));
         $this->setLog('error', __('messages.errors.update'), 'update', __('modules.moodle.title'), [
            'exception' => $queryException->getMessage()
         ]);      
      }

   }

   public function cancel()
   {
      $this->user_id       = '';
      $this->name          = '';
      $this->last_name     = '';
      $this->email         = '';
      $this->document      = '';
      $this->state         = '';
      $this->view          = 'create';
      $this->hydrate();
   }

}