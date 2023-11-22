@extends('layouts.app')
@section('content')

    <div class="grid grid-cols-1 gap-2 px-4">
        <div>
            <h1 class="font-medium text-4xl mt-4 my-4 text-siadi-blue-900">Este es el nuevo Módulo</h1>
            <hr class="border-siadi-blue-700">
        </div>
        <div class="pt-5">

        </div>

         <div>
             <h1>Reportes Nunca</h1>

             <table>
                 <thead>
                 <tr>
                     <th>ID</th>
                     <th>Columna1</th> <!-- Reemplaza con los nombres reales de tus columnas -->
                     <th>Columna2</th>
                     <!-- ... Agrega más columnas según sea necesario -->
                 </tr>
                 </thead>
                 <tbody>
                 @foreach($registros ?? '' as $registro)
                     <tr>
                         <td>{{ $registro->Facultad }}</td>
                         <td>{{ $registro->programa }}</td>
                         <!-- ... Muestra más columnas según sea necesario -->
                     </tr>
                 @endforeach
                 </tbody>
             </table>
         </div>
    </div>
@endsection
