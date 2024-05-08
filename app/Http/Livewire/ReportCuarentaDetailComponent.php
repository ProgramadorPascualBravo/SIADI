<?php

namespace App\Http\Livewire;

use App\Group;
use App\RolMoodle;
use App\StateEnrollment;
use App\Traits\ClearErrorsLivewireComponent;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class ReportCuarentaDetailComponent extends Component
{
    use ClearErrorsLivewireComponent, WithPagination, FlashMessageLivewaire, LogsTrail;

    

    public  $code, $rol, $email, $state, $period;

    public $hideable    = 'select';
    public $exportable  = true;
    public $complex = true;

    public function render()
    {
        $this->setLog('info', __('modules.enter'), 'render', __('modules.reportCuarenta.title'));
        return view('livewire.reportCuarenta.reportCuarenta-component', [
            'groups' => Group::where('state', 1)->get(),
            'roles'  => RolMoodle::where('state', 1)->select('name')->get(),
            'states'  => StateEnrollment::where('state', 1)->select(['name', 'id'])->get()
        ]);
    }
    
}