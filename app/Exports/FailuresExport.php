<?php


namespace App\Exports;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;

/**
 * Libreria https://docs.laravel-excel.com/3.1/exports/
 * Class FailuresExport
 * @package App\Exports
 */
class FailuresExport implements FromView
{
   use Exportable;

   protected $failures;
   protected $viewname;

   public function __construct($collection, $viewname)
   {
      $this->failures = $collection;
      $this->viewname = $viewname;
   }

   public function view(): View
   {
      return view($this->viewname, ['failures' => $this->failures()]);
   }

   public function failures(): Collection
   {
      return $this->failures;
   }
}