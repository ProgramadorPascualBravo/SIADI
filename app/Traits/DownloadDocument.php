<?php


namespace App\Traits;

/**
 * Trait DownloadDocument
 * @package App\Traits
 */
trait DownloadDocument
{
   public function download(string $basePath) {
      return response()->download(storage_path($basePath));
   }
}