<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Vista extends Model
{
    protected $table = 'reportesaccesocampus'; // Nombre de la vista en la base de datos

}
//
//namespace App\Http\Controllers;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Request;
//use App\Vista;
//use Excel;
//
//class ReporteNuncas extends Controller
//{
//    public function export()
//    {
//        $vistas = Vista::all();
//        return view('nombre_vista', ['vistas' => $vistas]);
//    }
//}

//class Vista extends Model
//{
//    protected $table = 'reportesAccesoCampus'; // Nombre de la vista en la base de datos
//}


