<?php


namespace App\Http\Livewire;


use App\Department;
use App\Traits\DeleteMassive;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Exports\DatatableExport;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DepartmentTable extends LivewireDatatable
{
   use DeleteMassive;

   public $model        = Department::class;
   public $hideable     = 'select';
   public $exportable   = true;

   public $relation     = 'category';

   protected $listeners = ['refreshLivewireDatatable'];

   public $beforeTableSlot = 'fragments.delete-massive';


   //TODO crear builder de los datos de la tabla

   public function columns() : array
   {
      $relation = $this->relation;
      $columns = [
         Column::checkbox(),
         Column::name('name')->label(Str::title(__('modules.input.name')))->searchable()->truncate()->filterable(),
         BooleanColumn::name('state')->label(Str::title(__('modules.input.state')))->filterable(),
         NumberColumn::name('programs.id:count')->label('# Programas')->filterable()->alignCenter(),
         DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable(),
      ];
      if (Auth::user()->can('category_write')) {
         array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignCenter());
      }
      if (Auth::user()->can('category_destroy')){
         array_push($columns, Column::callback(['id', 'name'], function ($id) use ($relation){
            return view('fragments.btn-action-delete', [
               'value' => $id, 'relation' => $relation
            ]);
         })->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
      }

      return $columns;
   }

   public function refreshLivewireDatatable()
   {
      parent::refreshLivewireDatatable(); // TODO: Change the autogenerated stub
   }

   /*public function export()
   {
      $export = collect();
      $this->forgetComputed();
      foreach ($this->getQuery()->get() as $item) {
         $export->push([
            'Nombre' => $item->name,
            'Estado' => $item->state == 1 ? 'Activo' : 'Desactivado',
         ]);
      }
      return Excel::download(new DatatableExport($export), 'DatatableExport.xlsx');
   }*/

   public function edit($id)
   {
      $this->emit('edit', $id);
   }
}
