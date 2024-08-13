<?php

namespace App;

use App\Traits\MonthScope;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Manager;

class ReportStudent extends Model
{
   use MonthScope;
   protected $table = 'student_detail';
   public function show()
   {

      $registros = Vista::all();
      return view('reportStudent.index', ['registros' => $registros]);
   }
}
