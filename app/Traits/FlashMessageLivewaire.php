<?php
namespace App\Traits;

/**
 * Trait FlashMessageLivewaire
 * @package App\Traits
 */
trait FlashMessageLivewaire
{
   public $message;

   public function showAlert(string $type, string $message)
   {
      $this->message = $message;
      $this->emit($type);
   }

   protected function refreshTable()
   {
      $this->emit('refreshLivewireDatatable');
   }
}