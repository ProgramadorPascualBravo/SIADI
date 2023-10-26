<?php

namespace App\Http\Livewire;

use App\Department;
use App\Program;
use App\Traits\DeleteMassive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class ProgramTable
 * @package App\Http\Livewire
 */
class ProgramTable extends LivewireDatatable
{

    use DeleteMassive;

    public $model        = Program::class;

    public $hideable     = 'select';

    public $exportable   = true;

    public $beforeTableSlot = 'fragments.delete-massive';

    public $relation     = 'program';

    protected $listeners = ['refreshLivewireDatatable'];

    public function builder()
    {
        return Program::query()->join('departments', 'departments.id', '=', 'programs.department_id');
    }

    public function columns() : array
    {
        $relation = $this->relation;
        $columns =  [
           Column::checkbox(),
           Column::name('name')->label(Str::title(__('modules.program.name')))->filterable()->searchable(),
           Column::name('code')->label(Str::title(__('modules.input.code')))->filterable()->searchable(),
           Column::name('faculty')->label(Str::title(__('modules.input.faculty')))->filterable()->searchable(),
           BooleanColumn::name('state')->label(Str::title(__('modules.input.state')))->filterable()->hide(),
           Column::name('department.name')->filterable(
              $this->department->pluck('name')
           )->label(Str::title(__('modules.category.name'))),
           NumberColumn::name('courses.id:count')->label('# Asignaturas')->filterable()->alignCenter(),
           Column::callback(['id'], function ($id){
              return view('fragments.link-to', ['route' => 'program-detail', 'params' => ['id' => $id], 'name' => 'Ver', 'btn' => 'btn-blue']);
           })->label(Str::title(__('modules.table.detail')))->alignCenter()->excludeFromExport(),
        ];

        if (Auth::user()->can('program_write')) {
             array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignCenter()->excludeFromExport());
        }
        if (Auth::user()->can('program_destroy')){
           array_push($columns, Column::callback(['id', 'name'], function ($id) use ($relation){
              return view('fragments.btn-action-delete', [
                 'value' => $id, 'relation' => $relation
              ]);
           })->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
        }

        return $columns;
   }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }

   public function getDepartmentProperty()
   {
      return Department::all('name');
   }
}
