<?php

namespace App\Observers;

use App\Mail\VerifyEmailUser;
use App\User;
use Illuminate\Support\Facades\Mail;

/**
 * Componente https://laravel.com/docs/7.x/eloquent#observers
 * Class UserObserver
 * @package App\Observers
 */
class UserObserver
{
   public function created(User $user)
   {
      Mail::to($user->username)->send(new VerifyEmailUser($user));
   }
}
