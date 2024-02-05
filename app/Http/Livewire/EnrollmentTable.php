<?php

namespace App\Http\Livewire;

use App\Enrollment;
use App\Group;
use App\Program;
use App\RolMoodle;
use App\StateEnrollment;
use App\Course;
use App\Traits\DeleteMassive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class EnrollmentTable
 * @package App\Http\Livewire
 */
class EnrollmentTable extends LivewireDatatable
{
    use DeleteMassive;
    public $model       = Enrollment::class;
    public $hideable    = 'select';
    public $exportable  = true;
    public $complex = true;
    public $persistComplexQuery = true;
    public $relation     = 'enrollment';
    public $beforeTableSlot = 'fragments.delete-massive';

    protected $listeners = ['refreshLivewireDatatable'];

    public function builder()
    {
        return $this->model::query()
            ->leftJoin('groups','groups.code','enrollments.code')
            ->leftJoin('students','students.email','enrollments.email')
            ->leftJoin('state_enrollments','state_enrollments.id','enrollments.state')
            ->join('courses','groups.course_id','=','courses.id')
            ->join('programs','courses.program_id','=','programs.id')
            ;
    }

    public function columns()
    {
        $relation = $this->relation;

        $columns = [
           Column::checkbox(),
           Column::name('code')->label(Str::title(__('modules.input.code')))->filterable(
              $this->groups->pluck('code')
           )->searchable(),
            //12/2022 inicio
           Column::name('group.course.name')
               ->label(Str::title(__('Asignatura')))
               ->filterable($this->courses)
               ->searchable(),
           Column::name('group.course.program.name')
               ->label(Str::title(__('Programa')))
               ->filterable($this->programs)
               ->searchable(),
            //12/2022 fin
            Column::name('user.document')->label('Cedula')->searchable()->filterable()->alignRight(),
            Column::name('user.name')->label('Nombres')->searchable()->filterable(),
            Column::name('user.last_name')->label('Apellidos')->searchable()->filterable(),

            Column::name('email')->label(Str::title(__('modules.input.email')))->filterable()->searchable(),
           Column::name('rol')
               ->label(Str::title(__('modules.role-moodle.name')))
               ->filterable($this->roles->pluck('name'))
               ->searchable(),
           Column::name('period')->label(Str::title(__('modules.input.period')))->filterable()->searchable(),
           Column::callback(['state_enrollment.name'], function($name) {
              return Str::title($name);
           })->label(Str::title(__('modules.input.state')))->filterable(
              $this->states->pluck('name')
           ),
           DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable(),
        ];
        if (Auth::user()->can('enrollment_write')) {
          array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignRight()->excludeFromExport());
        }
        if (Auth::user()->can('enrollment_destroy')){
           array_push($columns, Column::callback(['id', 'code'], function ($id) use ($relation){
              return view('fragments.btn-action-delete', [
                 'value' => $id, 'relation' => $relation
              ]);
           })->label('Eliminar')->alignCenter()->hide()->excludeFromExport());

        }

        return $columns;
    }

   public function getGroupsProperty()
   {
      return Group::select('code')->where('state', 1)->get();
   }

   public function getRolesProperty()
   {
      return RolMoodle::select('name')->where('state', 1)->get();
   }

   public function getStatesProperty()
   {
      return StateEnrollment::select(['id', 'name'])->where('state', 1)->get();
   }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }

    public function getCoursesProperty()
    {
        return Course::pluck('name');
    }

    public function getProgramsProperty()
    {
        return Program::pluck('name');
    }
}
