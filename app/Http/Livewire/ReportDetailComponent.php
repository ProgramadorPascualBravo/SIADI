<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Vista;
use Livewire\WithPagination;

class ReportDetailComponent extends Component
{
    use WithPagination;

    public $selectedFaculty = '';

    protected $registros;

    public function mount()
    {
        $this->registros = Vista::paginate(10);
    }

    public function render()
    {
        $uniqueFaculties = Vista::pluck('CodigoCurso')->unique();

        return view('livewire.reportsNever.report-detail-component', [
            'registros' => $this->registros,
            'uniqueFaculties' => $uniqueFaculties,
        ]);
    }

    public function filterByFaculty()
    {
        $this->registros = ($this->selectedFaculty)
            ? Vista::where('CodigoCurso', $this->selectedFaculty)->paginate(10)
            : Vista::paginate(10);

        $this->resetPage();
    }
}

