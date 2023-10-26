<?php


namespace App\Http\Livewire;


use App\Program;
use App\Traits\LogsTrail;
use Livewire\Component;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class ProgramDetailComponent
 * @package App\Http\Livewire
 */
class ProgramDetailComponent extends Component
{
   use LogsTrail;

   public $program;

   public function mount($program)
   {
      $this->program = $program;
   }

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.program.detail'));
      return view('livewire.program.details-component');
   }
}