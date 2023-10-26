<?php

namespace App\Http\Livewire;


use App\Group;
use App\Traits\LogsTrail;
use Livewire\Component;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class GroupDetailComponent
 * @package App\Http\Livewire
 */

class GroupDetailComponent extends Component
{
   use LogsTrail;

   public $group;

   public function mount($group)
   {
      $this->group = $group;
   }

   public function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.group.detail'));
      return view ('livewire.group.details-component');
   }
}