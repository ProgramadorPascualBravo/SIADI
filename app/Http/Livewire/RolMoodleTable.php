<?php

namespace App\Http\Livewire;

use App\Enrollment;
use App\RolMoodle;
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
 * Class RolMoodleTable
 * @package App\Http\Livewire
 */
class RolMoodleTable extends LivewireDatatable
{

   use DeleteMassive;

   public $model = RolMoodle::class;
   public $hideable = 'select';
   public $exportable = true;

   public $relation     = 'role_moodle';


   protected $listeners = ['refreshLivewireDatatable'];

   public $beforeTableSlot = 'fragments.delete-massive';

   public function builder()
   {
        return $this->model::query();
   }

    public function columns()
    {
        $columns = [
           Column::checkbox(),
           Column::name('name')->label(Str::title(__('modules.input.name')))->searchable()->filterable()->truncate(),
           BooleanColumn::name('state')->label(Str::title(__('modules.input.state')))->filterable()->alignCenter(),
           /*NumberColumn::callback(['name'], function ($name) {
              return Enrollment::where('rol', $name)->get()->count();
           })->label('# Matrículas')->filterable()->alignCenter(),*/
            NumberColumn::name('enrollments.id:count')->label('# Matrículas')->filterable()->alignCenter(),
           DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable(),
        ];
        if (Auth::user()->can('role_moodle_write')) {
          array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignCenter()->excludeFromExport());
        }
        if (Auth::user()->can('role_moodle_destroy')){
          array_push($columns, Column::delete()->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
        }
        return $columns;
    }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }
}
