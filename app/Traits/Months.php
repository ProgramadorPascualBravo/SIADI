<?php


namespace App\Traits;


use Arr;

/**
 * Trait Months
 * @package App\Traits
 */
trait Months
{
   static public $months = [
      '01' => 'Enero',
      '02' => 'Febrero',
      '03' => 'Marzo',
      '04' => 'Abril',
      '05' => 'Mayo',
      '06' => 'Junio',
      '07' => 'Julio',
      '08' => 'Agosto',
      '09' => 'Septiembre',
      '10' => 'Octubre',
      '11' => 'Noviembre',
      '12' => 'Diciembre',
   ];

   public function getMonths()
   {
      //$m = substr(now()->month, 0);
      
      //dd($m[0]);
      //if ($m[0])
      $flatten = Arr::flatten(self::$months);
      return array_splice($flatten, 0, now()->month);
   }

   protected function organizeDataByMonth($eloquent)
   {
      $data = collect();
      foreach (self::$months as $key => $value) {
         if ($key > now()->month) {
            break;
         }

         if (is_int($eloquent->keys()->search($key))) {
            $data->put($value, $eloquent->get($key));
            continue;
         }
         $data->put($value, 0);
      }
      return $data;
   }

}