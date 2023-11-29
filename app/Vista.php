<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Vista extends Model
{
    protected $table = 'reportesaccesocampus';

    public function show()
    {
        $registros = Vista::all();
        return view('reportsNever.index', ['registros' => $registros]);
    }

}



