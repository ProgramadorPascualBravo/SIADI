<?php


namespace App\Traits;


use Carbon\Carbon;

/**
 * https://laravel.com/docs/7.x/eloquent#global-scopes
 * Trait MonthScope
 * @package App\Traits
 */
trait MonthScope
{
      public function scopeMonth($query)
      {
         $query->whereMonth('created_at', Carbon::now()->month);
      }
}