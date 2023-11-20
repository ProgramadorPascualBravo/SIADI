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

    public function export()
    {
        return Excel::download(new ReporteNunca, 'reporte-nunca.xlsx');
    }
}






//class ReporteNunca extends Controller
//{
//    public function export()
//    {
//        $vista = Vista::all();
//
//        return Excel::create('reporte-nunca', function($excel) use ($vista) {
//            $excel->sheet('reporte-nunca', function($sheet) use ($vista) {
//                $sheet->fromArray($vista->toArray());
//            });
//        })->save('reporte-nunca.xlsx');
//    }
//}
