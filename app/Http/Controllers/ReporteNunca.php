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
    //  public function show()
    //    {
    //        $registros = $this->collection();
    //
    //        return view('reportsNever.index', ['registros' => $registros]);
    //    }

    public function show()
    {
        $registros = Vista::all(); // Reemplaza TuModelo con el nombre de tu modelo
        return view('reportsNever.index', ['registros' => $registros]);
    }

    public function export()
    {
        return Excel::download(new ReporteNunca, 'reporte-nunca.xlsx');
    }
}





