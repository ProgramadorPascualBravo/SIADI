<?php

namespace App\Http\Livewire;


use App\Student;
use App\StudentDBMoodle;
use App\Traits\FlashMessageLivewaire;
use App\Traits\LogsTrail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

/**
 * Libreria https://laravel-livewire.com/docs/2.x/quickstart
 * Class UserDetailComponent
 * @package App\Http\Livewire
 */
class UserDetailComponent extends Component
{
   use FlashMessageLivewaire, LogsTrail;

   public $user, $change_password = false, $profile;

   public $password_current, $password, $password_confirmation;

   function mount(User $user)
   {
      $this->profile = Auth::id() == $user->id ?? false;
      $this->user = $user;
   }

   function render()
   {
      $this->setLog('info', __('modules.enter'), 'render', __('modules.user.detail'), [
         'profile' => $this->user
      ]);
      return view('livewire.user.details-component');
   }

   public function update()
   {
      $this->validate([
         'password_current'      => 'required',
         'password'              => 'required|min:6',
         'password_confirmation' => 'required_with:password|same:password|min:6'
      ]);
      if(Hash::check($this->password_current, Auth::user()->getAuthPassword())) {
         Auth::user()->setAttribute('password', Hash::make(trim($this->password)))->save();
         $this->showAlert('alert-success', __('messages.success.update'));
         $this->cancel();
         $this->setLog('info', __('messages.success.update'), 'update', __('modules.user.detail'), [
            'info' => 'Password update'
         ]);
         return;
      }
      $this->showAlert('alert-success', __('messages.errors.update'));
      $this->setLog('error', __('messages.errors.update'), 'update', __('modules.user.detail'), [
         'info' => 'Not password update'
      ]);
   }

   private function cancel()
   {
      $this->password_current       = '';
      $this->password_confirmation  = '';
      $this->password               = '';
      $this->change_password        = false;
   }
}