<?php

namespace App;

use App\Traits\MonthScope;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Manager;

class LastAccess extends Model
{
   use MonthScope;
   protected $table = 'reportesaccesocampus';
   public function show()
   {

      $registros = Vista::all();
      return view('reportsNever.index', ['registros' => $registros]);
   }
}
