<?php


namespace App\Imports;


use App\Enrollment;
use App\Traits\FailuresImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Libreria https://docs.laravel-excel.com/3.1/imports/
 * Class EnrollmentImport
 * @package App\Imports
 */

class EnrollmentImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, SkipsOnError
{
   use Importable, FailuresImport;

   public $values;

   public function __construct()
   {
      $this->failures = new Collection();
   }

   public function rules(): array
   {
      return [
         'code'              => 'required|exists:groups,code',
         'email'             => 'required|email:rfc|exists:students,email',
         'rol'               => 'required|exists:roles_moodle,name',
         'state'             => 'required|exists:state_enrollments,id',
         'period'            => 'required',
      ];
   }

   public function model(array $row)
   {
      $this->sum(true);
      $this->values = $row;
      return new Enrollment([
         'code'    => trim($row['code']),
         'email'   => Str::lower(trim($row['email'])),
         'rol'     => Str::lower(trim($row['rol'])),
         'state'   => trim($row['state']),
         'period'   => trim($row['period']),
      ]);
   }

   public function onError(\Throwable $e)
   {
       $this->count['processed']--;
       $this->count['mistakes']++;
       $array = $this->values;
       $array['errors'] = [['Usuario matrículado en el curso.']];
       $this->failures->add($array);
   }

}