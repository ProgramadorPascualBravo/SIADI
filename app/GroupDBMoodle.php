<?php


namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupDBMoodle extends Model
{
   protected $table = 'mdl_course';

   protected $connection = 'mysql_moodle';

   public function getStartDateAttribute()
   {
      return Carbon::createFromTimestamp($this->startdate, ' America/Bogota')->format('d-m-Y h:i');
   }

   public function getVisibleAttribute()
   {
      return $this->visible == 1 ? 'Visible' : 'Oculto';
   }

}