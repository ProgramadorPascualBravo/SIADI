<?php
namespace App\Http\Livewire;

use App\ReportStudent;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ReportStudentDatatableComponent extends LivewireDatatable
{

    public $hideable    = 'select';
    public $exportable  = true;
    public $complex = true;
    public function builder()
    {
        return ReportStudent::query();
    }

    public function columns()
    {
        return [
            Column::name('id')
            ->label('ID')
                ->filterable()
                ->searchable(),

            Column::name('name')
            ->label('Nombre')
            ->filterable()
                ->searchable(),

            Column::name('last_name')
            ->label('Apellido')
            ->filterable()
                ->searchable(),

            Column::name('email')
            ->label('Correo')
            ->filterable()
                ->searchable(),

            Column::name('password')
            ->label('Contraseña')
            ->filterable()
                ->searchable(),

            Column::name('document')
            ->label('Documento')
            ->filterable()
                ->searchable(),

            Column::name('state')
            ->label('Estado')
            ->filterable()
                ->searchable(),

            Column::name('created_at')
            ->label('Fecha de Creación')
            ->filterable()
                ->searchable(),

            Column::name('updated_at')
            ->label('Fecha de Actualización')
            ->filterable()
                ->searchable(),

            Column::name('personalmail')
            ->label('Correo Personal')
            ->filterable()
                ->searchable(),

            Column::name('phone')
            ->label('Teléfono')
            ->filterable()
                ->searchable(),

            Column::name('cellphone')
            ->label('Celular')
            ->filterable()
                ->searchable(),

            Column::name('fecha_de_nacimiento')
            ->label('Fecha de Nacimiento')
            ->filterable()
                ->searchable(),

            Column::name('plan_estudios')
            ->label('Plan de Estudios')
            ->filterable()
                ->searchable(),

            Column::name('departamento')
            ->label('Departamento')
            ->filterable()
                ->searchable(),

            Column::name('jornada')
            ->label('Jornada')
            ->filterable()
                ->searchable(),
        ];

    }
}
