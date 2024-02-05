<?php

namespace App\Http\Livewire;

use App\Course;
use App\Program;
use App\Traits\DeleteMassive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class CourseTable
 * @package App\Http\Livewire
 */
class CourseTable extends LivewireDatatable
{
   use DeleteMassive;

   public $model        = Course::class;
   public $hideable     = 'select';
   public $exportable   = true;

   public $relation     = 'course';

   protected $listeners = ['refreshLivewireDatatable'];

   public $beforeTableSlot = 'fragments.delete-massive';

    public function builder()
    {
        return Course::query()->join('programs', 'programs.id', '=', 'courses.program_id');
    }

   public function columns()
   {
      $relation = $this->relation;
      $columns = [
         Column::checkbox(),
         Column::name('code')->label(Str::title(__('modules.input.code')))->filterable()->searchable(),
         Column::name('name')->label(Str::title(__('modules.input.name')))->filterable()->searchable(),
         BooleanColumn::name('state')->label(Str::title(__('modules.input.state')))->filterable(),
         Column::name('program.name')->filterable(
            $this->programs->pluck('name')
         )->label(__('modules.program.name'))->searchable(),
         NumberColumn::name('groups.id:count')->label('# Grupos')->filterable()->alignCenter(),
         DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable()->hide(),
         Column::callback(['id'], function ($id){
            return view('fragments.link-to', ['route' => 'course-detail', 'params' => ['id' => $id], 'name' => 'Ver', 'btn' => 'btn-blue']);
         })->label(Str::title(__('modules.table.detail')))->excludeFromExport(),
      ];
      if (Auth::user()->can('course_write')) {
         array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignRight()->excludeFromExport());
      }
      if (Auth::user()->can('course_destroy')){
         array_push($columns, Column::callback(['id', 'name'], function ($id) use ($relation){
            return view('fragments.btn-action-delete', [
               'value' => $id, 'relation' => $relation
            ]);
         })->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
      }

      return $columns;
   }

   public function getProgramsProperty()
   {
      return Program::select('name')->where('state', 1)->get();
   }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }
}
