<?php
namespace App\Http\Livewire;

use App\LastAccess;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LastAccessDatatableComponent extends LivewireDatatable
{

    public $hideable    = 'select';
    public $exportable  = true;
    public $complex = true;
    public function builder()
    {
        return LastAccess::query();
    }

    public function columns()
    {
        return [
            Column::name('Facultad')
                ->label('Facultad')
                ->filterable()
                ->searchable(),

            Column::name('Programa')
                ->label('Programa')
                ->filterable()
                ->searchable(),

            Column::name('Curso')
                ->label('Curso')
                ->filterable()
                ->searchable(),

            Column::name('nombreCur')
                ->label('Codigo Curso')
                ->filterable()
                ->searchable(),
                
            Column::name('Fecha_ini')
                ->label('Inicio Curso')
                ->filterable(),
                
            Column::name('Rol')
                ->label('Rol')
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
            Column::name('email')
                ->label('Correo')
                ->filterable()
                ->searchable(),
            Column::name('PersonalMail')
                ->label('Correo Personal')
                ->filterable()
                ->searchable(),
            Column::name('telefono')
                ->label('telefono')
                ->filterable()
                ->searchable(),
            Column::name('celular')
                ->label('celular')
                ->filterable()
                ->searchable(),
            Column::name('Periodo')
                ->label('Periodo')
                ->filterable()
                ->searchable(),
                
            Column::name('Matriculado')
                ->label('Estado Matricula')
                ->filterable(),
                
            Column::name('UltimoCur')
                ->label('Ultimo acceso cursos')
                ->filterable(),
            Column::name('UltimoAccesoPlataforma')
                ->label('Ultimo Acceso Plataforma')
                ->filterable(),
        ];
    }
}
