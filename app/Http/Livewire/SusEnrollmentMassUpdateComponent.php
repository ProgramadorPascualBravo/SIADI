<?php


namespace App\Http\Livewire;


use App\Imports\EnrollmentExtendImport;
use App\Imports\EnrollmentImport;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\DownloadDocument;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class EnrollmentMassCreationComponent
 * @package App\Http\Livewire
 */
class SusEnrollmentMassUpdateComponent extends Component
{
   use FlashMessageLivewaire, WithFileUploads, DownloadDocument, ClearErrorsLivewireComponent, LogsTrail;

   public $quantity = null;

   protected $listeners = ['setQuantity'];

   public function render()
   {
      return view('livewire.susenrollment.mass-update-component');
   }

   public function cancel()
   {
       $this->quantity = null;
       $this->emit('cancel');
       $this->hydrate();
   }

   public function setQuantity(array $quantity)
   {
      $this->quantity = $quantity;
   }
}
