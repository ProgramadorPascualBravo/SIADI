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
            Column::name('Estado_de_Entrega')
                ->label('Estado de Entrega')
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

            Column::name('Correo_Docente')
                ->label('Correo Docente')
                ->filterable()
                ->searchable(),

            Column::name('Semestre')
                ->label('Semestre')
                ->filterable()
                ->searchable(),

            Column::name('Codigo_SIADI')
                ->label('Codigo SIADI')
                ->filterable()
                ->searchable(),

            Column::name('Codigo_Asignatura')
                ->label('Codigo Asignatura')
                ->filterable()
                ->searchable(),

            Column::name('Nombre_MAA')
                ->label('Nombre MAA')
                ->filterable()
                ->searchable(),

            Column::name('Grupo')
                ->label('Grupo')
                ->filterable()
                ->searchable(),

            Column::name('Url_Curso')
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

            Column::name('Numero_Estudiantes')
                ->label('Numero de Estudiantes')
                ->filterable()
                ->searchable(),
        ];
    }
}
