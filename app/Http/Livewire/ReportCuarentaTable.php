<?php

namespace App\Http\Livewire;

use App\LastAccess; 
use App\Traits\DeleteMassive;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ReportCuarentaTable extends LivewireDatatable 
{
   use DeleteMassive;
   public $model       = ReportDetailComponent::class; 
   public $hideable    = 'select';
   public $exportable  = true;
   public $complex = true;
   public $persistComplexQuery = true;

   protected $listeners = ['refreshLivewireDatatable'];

   public function builder()
   {
      return $this->model::query();
   }

   public function columns()
   {
      $columns = [
         Column::name('user_id')->label('User ID')->filterable()->searchable(), 
         Column::name('last_login')->label('Last Login')->filterable()->searchable(), 
         DateColumn::name('created_at')->label('Created At')->filterable(), 
      ];

      return $columns;
   }
}
