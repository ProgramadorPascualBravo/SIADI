<?php


namespace App\Traits;

/**
 * Trait SetParamsTable
 * @package App\Traits
 */
trait SetParamsTable
{
   public function setNewDate($search)
   {
      $this->params = $search;
      $this->refreshLivewireDatatable();
   }

}