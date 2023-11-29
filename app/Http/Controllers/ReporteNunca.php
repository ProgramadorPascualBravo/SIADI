<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vista;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReporteNunca extends Controller implements FromCollection
{
    public function collection()
    {
        return Vista::all();
    }

    public function show()
    {
        $registros = Vista::all();
        return view('reportsNever.index', ['registros' => $registros]);
    }

    public function export()
    {
        return Excel::download(new ReporteNunca, 'reporte-nunca.xlsx');
    }
}





