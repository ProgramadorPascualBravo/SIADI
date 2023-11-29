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
        $this->registros = Vista::all();
    }

    public function render()
    {
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
        $this->resetPage();
        $this->render();
    }
}
