<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsTrail
{
      protected function setLog(string $type, string $message, string $method, string $module, $params = null) {
          $information = [
             'usuario'   => Auth::user()->username,
             'context'   => get_class(),
             'method'    => $method,
             'module'    => $module,
          ];
          if (! is_null($params)) {
             $information['params'] = $params;
          }
          Log::channel('trail')->{$type}($message,
             $information
          );
      }


}