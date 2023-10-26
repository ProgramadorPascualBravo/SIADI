<?php


namespace App\Traits;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Validators\Failure;

/**
 * Trait FailuresImport
 * @package App\Traits
 */
trait FailuresImport
{
   protected $failures;

   public $count = ['processed' => 0, 'mistakes' => 0];

   public function onFailure(Failure ...$failures)
   {
      $this->sum(false);
      $array = [];
      $errors = [];
      $i = true;
      foreach ($failures as $failure) {
         if ($i) {
            $array = $failure->values();
            $i = false;
         }
         array_push($errors, $failure->errors());
      }
      $array['errors'] = array_values($errors);
      $this->failures->add($array);
   }

   public function failures(): Collection
   {
      return $this->failures;
   }

   protected function sum(bool $type)
   {
      if ($type) {
         $this->count['processed']++;
      } else {
         $this->count['mistakes']++;
      }
   }
}