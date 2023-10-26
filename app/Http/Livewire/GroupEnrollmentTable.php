<?php


namespace App\Http\Livewire;


use App\Enrollment;
use App\RolMoodle;
use App\StateEnrollment;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class GroupEnrollmentTable
 * @package App\Http\Livewire
 */
class GroupEnrollmentTable extends LivewireDatatable
{
   public $model = Enrollment::class;
   public $hideable     = 'select';

   public $exportable   = true;


   public function builder()
   {
      return $this->model::query()
          //->join('enrollments', 'enrollments.code','=','groups.code')
          ->join('students','students.email','=','enrollments.email')
          ->join('state_enrollments','state_enrollments.id','=','enrollments.state')
          ->where('code', $this->params);

   }

   public function columns() : array
   {
      $columns = [
         Column::name('code')->label(__('modules.input.code'))->searchable()->filterable(),
         Column::name('email')->label(__('modules.input.email'))->searchable()->filterable(),

         //12/2022 inicio
         Column::name('user.document')->label('Cedula')->searchable()->filterable()
            ->alignRight(),
         Column::name('user.name')->label('Nombres')->searchable()->filterable(),
         Column::name('user.last_name')->label('Apellidos')->searchable()->filterable(),
         //12/2022 fin

         Column::name('rol')->label('Rol matrícula')->filterable(
            $this->roles->pluck('name')
         )->searchable(),
         Column::callback(['state_enrollment.name'], function($name) {
            return Str::title($name);
         })->label(Str::title(__('modules.input.state')))->filterable(
            $this->states->pluck('name')
         ),
         Column::name('period')->label(__('modules.input.period'))->filterable()->searchable(),
         DateColumn::name('created_at')->filterable()->label(__('modules.table.created')),
         Column::callback(['code', 'email'], function ($code, $email) {
            return Enrollment::lastEntry($code, $email)[0]->ultimoCur ?? 'Nunca';
         })->label("Último ingreso")->filterable()->alignRight(),

         Column::callback(['user.id'], function ($id){
            return view('fragments.link-to', ['route' => 'moodle-detail', 'params' => ['id' => $id], 'name' => 'Ver', 'btn' => 'btn-blue']);
         })->label(__('modules.table.detail'))->alignCenter()->excludeFromExport()
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
