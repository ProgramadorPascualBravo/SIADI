<?php

namespace App;

use App\Traits\Months;
use App\Traits\MonthScope;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Str;

class Student extends Model
{
   use MonthScope;

   protected $table = 'students';

   protected $fillable = [
      'name',
      'last_name',
      'email',
      'password',
      'document',
      'state',
      'cellphone',
      'phone',
      'personalmail',
      'fecha_de_nacimiento'
   ];

   public function enrollments()
   {
      return $this->hasMany(Enrollment::class, 'email', 'email');
   }

   public function user_external()
   {
      return $this->hasOne(StudentDBMoodle::class, 'username', 'email');
   }

   public function getFullNameAttribute()
   {
      return Str::title($this->name . ' ' . $this->last_name);
   }

   // Accessor para obtener la fecha en el formato d/m/Y
   public function getFechaDeNacimientoAttribute($value)
   {
      // Verifica si el valor es nulo o está vacío
      if ($value) {
         try {
            return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
         } catch (\Exception $e) {
            // En caso de que la fecha no esté en el formato esperado, retorna el valor original o un valor por defecto
            return $value;
         }
      }

      return 'Fecha no disponible'; // o cualquier valor predeterminado que prefieras
   }


   public function setFechaDeNacimientoAttribute($value)
   {
      // Verifica si el valor es nulo o está vacío
      if ($value) {
         // Verifica si el valor tiene 8 caracteres y está en el formato esperado YYYYMMDD
         if (strlen($value) == 8 && preg_match('/^\d{8}$/', $value)) {
            // Convierte la fecha al formato Y-m-d
            $this->attributes['fecha_de_nacimiento'] = Carbon::createFromFormat('Ymd', $value)->format('Y-m-d');
         } else {
            // Si no está en el formato esperado, lo guarda tal cual
            $this->attributes['fecha_de_nacimiento'] = $value;
         }
      } else {
         // Si el valor es nulo o vacío, lo guarda como nulo o maneja como prefieras
         $this->attributes['fecha_de_nacimiento'] = null;
      }
   }
}
