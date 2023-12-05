<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Vista;
use Livewire\WithPagination;

class ReportDetailComponent extends Component
{
    use WithPagination;

    public $registros;
    public $selectedFaculty = '';

    public function mount()
    {
        // No es necesario cargar todos los registros al inicio
        $this->registros = Vista::paginate(10);
    }

    public function render()
    {
        // Utiliza la variable $this->selectedFaculty directamente en la consulta
        $filteredRecords = ($this->selectedFaculty)
            ? Vista::where('Facultad', $this->selectedFaculty)->paginate(10)
            : Vista::paginate(10);

        $uniqueFaculties = Vista::pluck('Facultad')->unique();

        return view('livewire.reportsNever.report-detail-component', [
            'registros' => $filteredRecords,
            'uniqueFaculties' => $uniqueFaculties,
        ]);
    }

    public function filterByFaculty()
    {
        // No es necesario llamar a $this->render() manualmente, Livewire lo hará automáticamente
        $this->resetPage();
    }
}
