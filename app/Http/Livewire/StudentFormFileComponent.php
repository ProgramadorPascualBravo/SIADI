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
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart

 * Class StudentFormFileComponent
 * @package App\Http\Livewire
 */
class StudentFormFileComponent extends Component
{
   use WithFileUploads, DownloadDocument, ClearErrorsLivewireComponent, LogsTrail;

   public $file;

   public $listeners = ['analyze', 'cancel'];

   public function render()
   {
      return view('livewire.form-file.form-export-student');
   }

   public function analyze()
   {
      $this->validate([
         'file' => 'required|mimes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,xlsx,xls'
      ]);

      try {
         sleep(2);
         $import = new StudentsImport();
         $import->import($this->file);
         $this->emit('setQuantity', $import->count);
         if ($import->failures()->count() > 0) {
            $this->setLog('info', 'processing', 'analyze', __('modules.moodle.massive'), [
               'quantity' => $import->count, 'file' => $this->file
            ]);
            return Excel::download(new FailuresExport($import->failures(), 'exports.export-student'), 'Errores_Usuarios.xlsx');
         }
         $this->setLog('info', 'processing', 'analyze', __('modules.moodle.massive'), [
            'quantity' => $import->count, 'file' => $this->file
         ]);
      } catch (FileException | QueryException | \Exception $exception) {
         $this->setLog('error', 'processing', 'analyze', __('modules.moodle.massive'), [
            'exception' => $exception->getMessage()
         ]);
      }
   }

   public function cancel()
   {
      $this->file = null;
   }
}