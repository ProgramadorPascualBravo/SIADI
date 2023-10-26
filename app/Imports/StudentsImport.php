<?php

namespace App\Imports;

use App\Student;
use App\Traits\FailuresImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Libreria https://docs.laravel-excel.com/3.1/imports/
 * Class StudentsImport
 * @package App\Imports
 */
class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, WithProgressBar
{

   use Importable, FailuresImport;

   public function __construct()
   {
      $this->failures = new Collection();
   }

   public function rules(): array
   {
      $rules = [
         'name'          => 'required',
         'last_name'     => 'required',
         'document'      => 'required|unique:students,document|numeric',
      ];

      $rules['email'] = [
         'required',
         'email:rfc',
         'unique:students,email',
         'unique:students,document',
         function($attribute, $value, $fail) {
            $cleanValue = str_replace(' ', '', $value);
            $cleanValue = preg_replace('/[^A-Za-z0-9@._\-]/', '', $value); // Removes special chars.
            $cleanValue = strtolower($cleanValue);

            if ($value !== $cleanValue) {
               $fail(__('validation.moodle_username'));
            }
         },
      ];
      return $rules;
   }

   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->sum(true);
        return new Student([
           'name'         => Str::title(trim($row['name'])),
           'last_name'    => Str::title(trim($row['last_name'])),
           'document'     => trim($row['document']),
           'password'     => md5(trim($row['document'])),
           'email'        => trim($row['email']),
        ]);
    }


}
