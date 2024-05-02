<?php

namespace App;

use App\Traits\MonthScope;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Manager;

class ReportCuarenta extends Model
{
   use MonthScope;
   protected $table = 'reporte140';
   
   public function show()
   {
      $registros = $this->all(); 
      return view('reportCuarenta.index', ['registros' => $registros]);
   }
}