<?php


namespace App\Http\Livewire;


use App\Exports\FailuresExport;
use App\Imports\StudentsImport;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\DownloadDocument;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class StudentMassCreationComponent
 * @package App\Http\Livewire
 */
class StudentMassCreationComponent extends Component
{
   use FlashMessageLivewaire, WithFileUploads, DownloadDocument, ClearErrorsLivewireComponent, LogsTrail;

   public $quantity = null;

   protected $listeners = ['setQuantity'];

   public function render()
   {
      $this->setLog('error', __('modules.enter'), 'render', __('modules.moodle.massive'));
      return view('livewire.student.mass-creation-component');
   }

   public function cancel()
   {
       $this->quantity = null;
       $this->hydrate();
       $this->emit('cancel');
   }

   public function setQuantity(array $quantity)
   {
      $this->quantity = $quantity;
   }
}