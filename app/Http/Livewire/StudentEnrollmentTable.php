<?php


namespace App\Http\Livewire;


use App\Enrollment;
use App\RolMoodle;
use App\StateEnrollment;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class StudentEnrollmentTable
 * @package App\Http\Livewire
 */

class StudentEnrollmentTable extends LivewireDatatable
{
   public $model = Enrollment::class;
   public $hideable     = 'select';

   public $exportable   = true;

   protected $listeners = ['refreshLivewireDatatable'];

   public function builder()
   {
      return $this->model::query()
          ->join('groups','groups.code','=','enrollments.code')
          ->join('state_enrollments','state_enrollments.id','=','enrollments.state')
          ->join('courses','courses.id','=','groups.course_id')
          ->where('email', $this->params)
          ;


   }

   public function columns()
   {
      $columns = [
          Column::callback(['group.course.name', 'group.course.id'], function ($name, $id){
            return view('fragments.link-to-name', ['route' => 'course-detail', 'params' => ['id' => $id], 'name' => $name]);
         })
              ->label(__('modules.course.name'))
              ->searchable()
              ->exportCallback(function($name){return $name;}),
         Column::callback(['group.name', 'group.id'], function ($name, $id){
            return view('fragments.link-to-name', ['route' => 'group-detail', 'params' => ['id' => $id], 'name' => $name]);
         })->label(__('modules.group.name'))
             ->searchable()
             ->alignCenter()
             ->exportCallback(function($name){return $name;}),
         Column::name('rol')->filterable(
            $this->roles->pluck('name')
         )->label('Rol matrícula'),
         Column::callback(['state_enrollment.name'], function($name) {
            return Str::title($name);
         })->label(Str::title(__('modules.input.state')))->filterable(
            $this->states->pluck('name')
         )->alignRight(),
         DateColumn::name('created_at')->filterable()->label(__('modules.table.created')),
         Column::callback(['code', 'email'], function ($code, $email) {
            return Enrollment::lastEntry($code, $email)[0]->ultimoCur ?? 'Nunca';
         })->label("Último ingreso")->filterable()->alignRight(),
      ];

      return $columns;
   }

   public function getRolesProperty()
   {
      return RolMoodle::all('name');
   }

   public function getStatesProperty()
   {
      return StateEnrollment::select(['id', 'name'])->where('state', 1)->get();
   }

}
