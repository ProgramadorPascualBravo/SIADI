<?php


namespace App\Http\Livewire;


use App\Course;
use App\Enrollment;
use App\Group;
use App\Program;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

/**
 * Libreria https://github.com/mediconesystems/livewire-datatables
 * Class CourseGroupTable
 * @package App\Http\Livewire
 */
class CourseGroupTable extends LivewireDatatable
{
   public $model        = Group::class;

   public $hideable     = 'select';

   public $exportable   = true;

   public function builder()
   {
      return $this->model::query()->where('course_id', $this->params);
   }

   public function columns() : array
   {
      $columns = [
         Column::name('name')->label(__('modules.group.name'))->searchable()->filterable(),
         Column::name('code')->label(__('modules.input.code'))->searchable()->filterable(),
         BooleanColumn::name('state')->filterable()->label(__('modules.input.state')),
         DateColumn::name('created_at')->filterable()->label(__('modules.table.created')),
         Column::callback(['id'], function ($id){
            return view('fragments.link-to', ['route' => 'group-detail', 'params' => ['id' => $id], 'name' => 'Ver', 'btn' => 'btn-blue']);
         })->label(__('modules.table.detail')),
      ];

      return $columns;
   }
}