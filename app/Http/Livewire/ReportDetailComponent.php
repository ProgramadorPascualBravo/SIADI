<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Vista;
use Livewire\WithPagination;

class ReportDetailComponent extends Component
{
    use WithPagination;

    protected $registros;
    public $selectedFaculty = '';

    public function mount()
    {
        $this->registros = Vista::paginate(10);
    }

    public function render()
    {
        $uniqueFaculties = Vista::pluck('Facultad')->unique();

        return view('livewire.reportsNever.report-detail-component', [
            'registros' => $this->registros,
            'uniqueFaculties' => $uniqueFaculties,
        ]);
    }

    public function filterByFaculty()
    {
        $this->registros = ($this->selectedFaculty)
            ? Vista::where('Facultad', $this->selectedFaculty)->paginate(10)
            : Vista::paginate(10);

        $this->resetPage();
    }
}

