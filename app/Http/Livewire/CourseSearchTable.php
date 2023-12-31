<?php


namespace App\Http\Livewire;


use App\Course;
use App\Traits\LogsTrail;
use App\Traits\SetParamsTable;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class CourseSearchTable
 * @package App\Http\Livewire
 */

class CourseSearchTable extends LivewireDatatable
{
   use SetParamsTable, LogsTrail;

   public $model           = Course::class;

   public $exportable      = true;

   public $hideable        = 'select';

   protected $listeners    = ['setNewDate'];

   public function builder()
   {
      return $this->model::query()
         ->where('name', 'like', "%$this->params%")
         ->orWhere('code', 'like', "%$this->params%");
   }

   public function columns() : array
   {
      $columns = [
         Column::name('code')->label(__('modules.input.code'))->filterable()->searchable(),
         Column::name('name')->label(__('modules.course.name'))->filterable()->searchable(),
         BooleanColumn::name('state')->label(__('modules.input.state'))->filterable()->alignCenter(),
         NumberColumn::name('groups.id:count')->label('# de Grupos')->filterable()->alignCenter(),
         DateColumn::name('created_at')->label(__('modules.table.created'))->filterable(),
         Column::callback(['id'], function ($id){
            return view('fragments.link-to', ['route' => 'course-detail', 'params' => ['id' => $id], 'name' => 'Ver', 'btn' => 'btn-blue']);
         })->label(__('modules.table.detail'))->alignCenter()->excludeFromExport(),
      ];
      return $columns;
   }

   public function render()
   {
      $this->emit('stopClear');
      $this->setLog('info', 'Búsqueda asignatura', 'render', __('modules.search.title'));
      return parent::render(); // TODO: Change the autogenerated stub
   }
}
