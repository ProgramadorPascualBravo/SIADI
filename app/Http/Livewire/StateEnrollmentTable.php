<?php

namespace App\Http\Livewire;

use App\Enrollment;
use App\StateEnrollment;
use App\Traits\DeleteMassive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class StateEnrollmentTable
 * @package App\Http\Livewire
 */
class StateEnrollmentTable extends LivewireDatatable
{
   use DeleteMassive;

   public $model        = StateEnrollment::class;
   public $hideable     = 'select';
   public $exportable   = true;

   public $relation     = 'state_enrollment';


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
         Column::callback(['id'], function ($id){return $id;})->label(Str::title(__('modules.input.code'))),
         Column::name('name')->label(Str::title(__('modules.input.name')))->searchable()->filterable()->truncate(),
         BooleanColumn::name('delete_moodle')->label(Str::title(__('modules.input.delete_moodle')))->filterable()->alignCenter(),
         BooleanColumn::name('state')->label(Str::title(__('modules.input.state')))->filterable()->alignCenter(),
         NumberColumn::name('enrollments.id:count')->label('# Matrículas')->filterable()->alignCenter(),
         DateColumn::name('created_at')->label(Str::title(__('modules.table.created')))->filterable(),
      ];
      if (Auth::user()->can('state_enrollment_write')) {
         array_push($columns, Column::name('id')->view('livewire.datatables.edit')->label('Editar')->alignCenter()->excludeFromExport());
      }
      if (Auth::user()->can('state_enrollment_destroy')){
         array_push($columns, Column::delete()->label('Eliminar')->alignCenter()->hide()->excludeFromExport());
      }
      return $columns;
   }

   public function edit($id)
   {
      $this->emit('edit', $id);
   }
}
