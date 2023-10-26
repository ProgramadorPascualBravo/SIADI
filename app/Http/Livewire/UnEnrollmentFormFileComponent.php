<?php


namespace App\Http\Livewire;


use App\Exports\FailuresExport;
use App\Imports\UnEnrollmentImport;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\DownloadDocument;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class EnrollmentFormFileComponent
 * @package App\Http\Livewire
 */
class UnEnrollmentFormFileComponent extends Component
{
   use WithFileUploads, DownloadDocument, ClearErrorsLivewireComponent, LogsTrail;

   public $file, $type = 1;

   public $listeners = ['analyze', 'cancel'];

   public function render()
   {
      return view('livewire.form-file.form-export-unenrollment');
   }

   public function analyze()
   {
      $this->validate([
         'file' => 'required|mimes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,xlsx,xls'
      ]);

      try {
         sleep(2);

         $import = new UnEnrollmentImport();
         $import->import($this->file);
         $this->emit('setQuantity', $import->count);

         if ($import->failures()->count() > 0) {

             $array = [];
             $errors = [];
             $i=0;

             foreach ($import->failures() as $failure) {

                 $pos=array_search( $failure->row(),array_column($array,"row"));

                 if($pos >= 0 && $pos!==false){

                     array_push($array[$pos]['errors'], $failure->errors()[0]);
                 }else{
                     array_push($array, $failure->values());
                     $array[$i]['row'] = $failure->row();
                     array_push($errors, $failure->errors());
                     $array[$i]['errors'] = array_values($errors[$i]);
                     $i++;
                 }
             }

            return Excel::download(
                new FailuresExport(collect($array), 'exports.export-unenrollment'),
               'Errores_DesMatriculas.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
         }

         $this->setLog('info', 'processing', 'analyze', __('modules.unenrollment.massive'), [
            'quantity' => $import->count, 'file' => $this->file
         ]);
      } catch (FileException | QueryException | \Exception $exception) {
         $this->setLog('error', 'processing', 'analyze', __('modules.unenrollment.massive'), [
            'exception' => $exception->getMessage()
         ]);
      }
   }

   public function cancel()
   {
      $this->file = null;
   }
}
