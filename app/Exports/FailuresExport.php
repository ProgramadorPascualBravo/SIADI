<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Clase para exportar fallos durante la importación usando Laravel Excel
 */
class FailuresExport implements FromView
{
   use Exportable;

   protected $failures;
   protected $viewname;

   /**
    * Constructor que recibe una colección de fallos y el nombre de la vista.
    *
    * @param Collection $collection La colección de errores capturados
    * @param string $viewname Nombre de la vista que usará Laravel Excel
    */
   public function __construct(Collection $collection, $viewname)
   {
      $this->failures = $collection;
      $this->viewname = $viewname;
   }

   /**
    * Retorna la vista que será usada para generar el archivo Excel.
    *
    * @return View
    */
   public function view(): View
   {
      return view($this->viewname, ['failures' => $this->failures]);
   }

   /**
    * Devuelve la colección de fallos.
    *
    * @return Collection
    */
   public function failures(): Collection
   {
      return $this->failures;
   }
}
