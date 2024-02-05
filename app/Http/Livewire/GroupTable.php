<?php

namespace App\Http\Livewire;

use App\Course;
use App\Enrollment;
use App\EnrollmentMoodle;
use App\Group;
use App\Traits\DeleteMassive;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class GroupTable
 * @package App\Http\Livewire
 */
class GroupTable extends LivewireDatatable
{
    use DeleteMassive;

    public $model       = Group::class;
    public $hideable    = 'select';
    public $exportable  = true;
    public const MATRICULADO = 1;
    public const FINALIZADA = 3;

    public $beforeTableSlot = 'fragments.delete-massive';

    public $relation     = 'group';

    protected $listeners = ['refreshLivewireDatatable'];

    public function builder()
    {
        return $this->model::query()->join('courses', 'courses.id', '=', 'course_id');

    }

    public function columns()
    {
        $relation = $this->relation;
        $columns =  [
           Column::checkbox(),
           Column::name('code')->label(Str::title(__('modules.input.code')))->searchable()->filterable(),
           Column::callback(['name', 'course.name'], function ($name, $course_name){
              return "Grupo: {$name} de {$course_name}";
           })->label(Str::title(__('modules.group.name')))->searchable()->filterable(),
           BooleanColumn::name('state')->label('Estado')->filterable()->hide(),
           Column::name('course.name')->filterable(
              $this->courses->pluck('name')
           )->label(Str::title(__('modules.course.name'))),
           NumberColumn::callback(['code', 'name'], function ($code) {
              return Enrollment::where(['code' => $code, 'state' => self::MATRICULADO])->get()->count();
           })->label('# Matrículas Activas')->filterable()->alignCenter(),
           DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable()->hide(),
           Column::callback(['id'], function ($id){
              return view('fragments.link-to', ['route' => 'group-detail', 'params' => ['id' => $id], 'name' => "Ver", 'btn' => 'btn-blue']);
           })->label(Str::title(__('modules.table.detail')))->alignCenter()->excludeFromExport(),

        ];
        if (Auth::user()->can('group_write')) {
           array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignCenter());
           array_push($columns, Column::callback(['code'], function ($code){
              return view('livewire.datatables.close', ['value' => $code]);
           })->label('Cerrar Matrículas')->alignCenter()->excludeFromExport());

        }
        if (Auth::user()->can('group_destroy')){
           array_push($columns, Column::callback(['id', 'name'], function ($id) use ($relation){
              return view('fragments.btn-action-delete', [
                 'value' => $id, 'relation' => $relation
              ]);
           })->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
        }

       return $columns;
    }

   public function getCoursesProperty()
   {
      return Course::select('name')->where('state', 1)->get();
   }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }
   public function close($code)
   {
      try {

         Enrollment::where('code', $code)
                  ->where('state', self::MATRICULADO)
                  ->update([
                     'state' => self::FINALIZADA
                  ]);

         EnrollmentMoodle::where('code', $code)->delete();
         //$deleted = EnrollmentMoodle::where('code', $code)->delete();
         //dd($deleted);

# Linea de codigo anterior - 21/02/2022

                  #Enrollment::where('code', $code)
          #        ->where('state', self::MATRICULADO)
           #       ->update([
            #         'state' => self::FINALIZADA
             #     ]);

         $this->emit('showAlert', 'alert-success', 'Operación realizada!');
         $this->setLog('info', 'Cerrar matriculas', 'close', __('modules.group.detail'), [
             'code' => $code
         ]);
      } catch (QueryException $queryException) {
         $this->emit('showAlert', ['alert-error', $queryException->getMessage()]);;
         $this->setLog('error', 'Cerrar matriculas', 'close', __('modules.group.detail'), [
            'exception' => $queryException->getMessage()
         ]);
      }
   }
}
