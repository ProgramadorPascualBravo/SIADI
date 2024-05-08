<?php
namespace App\Http\Livewire;


use App\ReportCuarenta;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ReportCuarentaDatatableComponent extends LivewireDatatable
{

    public $hideable    = 'select';
    public $exportable  = true;
    public $complex = true;
    public function builder()
    {
        return ReportCuarenta::query();
    }

    public function columns()
    {
        return [
            Column::name('Estado De Entrega')
                ->label('Estado De Entrega')
                ->filterable()
                ->searchable(),

            Column::name('Documento')
                ->label('Documento')
                ->filterable()
                ->searchable(),

                Column::name('Nombre')
                ->label('Nombre')
                ->filterable()
                ->searchable(), 

                Column::name('Correo Docente')
                ->label('Correo Docente')
                ->filterable()
                ->searchable(),    
                       
                Column::name('Semestre')
                ->label('Semestre')
                ->filterable()
                ->searchable(),                

                Column::name('Codigo SIADI')
                ->label('Codigo SIADI')
                ->filterable()
                ->searchable(),               

                Column::name('Codigo Asignatura')
                ->label('Codigo Asignatura')
                ->filterable()
                ->searchable(),
                
                Column::name('Nombre MAA')
                ->label('Nombre MAA')
                ->filterable()
                ->searchable(),

                Column::name('Grupo')
                ->label('Grupo')
                ->filterable()
                ->searchable(),               

                Column::name('Url Curso')
                ->label('Url Curso')
                ->filterable()
                ->searchable(),
                   
                Column::name('Departamento')
                ->label('Departamento')
                ->filterable()
                ->searchable(),

                Column::name('Programa')
                ->label('Programa')
                ->filterable()
                ->searchable(), 
                
                Column::name('Numero de Estudiantes')
                ->label('Numero de Estudiantes')
                ->filterable()
                ->searchable(),
        ];
    }
}
