<?php


namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentDBMoodle extends Model
{
   protected $table = 'mdl_user';

   protected $connection = 'mysql_moodle';

   protected $fillable = ['username', 'suspended'];

   public $timestamps = false;

   public function getFirstEntryAttribute()
   {
      return Carbon::createFromTimestamp($this->firstaccess, ' America/Bogota')->format('d-m-Y h:i');
   }

   public function getLastEntryAttribute()
   {
      return Carbon::createFromTimestamp($this->currentlogin, ' America/Bogota')->format('d-m-Y h:i');

   }
}