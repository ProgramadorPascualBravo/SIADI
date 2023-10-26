<?php


namespace App\Traits;

/**
 * Trait ClearErrorsLivewireComponent
 * @package App\Traits
 */
trait ClearErrorsLivewireComponent
{
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
