<?php


namespace App\Imports;


use App\Enrollment;
use App\Traits\FailuresImport;
use App\Traits\LogsTrail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Validators\Failure;


/**
 * Libreria https://docs.laravel-excel.com/3.1/imports/
 * Class EnrollmentImport
 * @package App\Imports
 */

class UnEnrollmentImport implements ToCollection, WithHeadingRow, WithValidation , SkipsOnFailure, SkipsOnError
{
   use Importable, SkipsErrors, SkipsFailures,LogsTrail;

   public $values;
   private const DESMATRICULADO = 4;

   public function __construct()
   {
      $this->failures = new Collection();
   }

    public function withValidator($validator){

        $validator->after(function ($validator) {




            foreach($validator->getData() as $key=>$data){

                $u = Enrollment::where('email', $data['usuario'])
                    ->where('code', $data['curso'])
                    ->first();

                if (!isset($u)) {
                    //dd("A",$u);
                    $validator->errors()->add($key,'La matricula no existe');
                }

                $u = Enrollment::where('email', $data['usuario'])
                    ->where('code', $data['curso'])
                    ->where('state',1)
                    ->first();


                if (!isset($u)) {
                    //dd("B",$u);

                    $validator->errors()->add($key,'La matricula debe estar en estado matricualda');
                }

                $repeated = array_keys($validator->getData(), $data);

                $repeatedResgitrado = array_keys($validator->errors()->messages(), $repeated[count($repeated)-1]);

                if(!$repeatedResgitrado){

                    foreach ($repeated as $key=>$item){
                        if($key>0){
                            $validator->errors()->add($item,'Registro repetido');
                        }
                    }

                }

            }
        });

    }
   public function rules(): array
   {
       return [
         'curso'    => 'required|exists:groups,code',
         //'usuario'  => 'required|email:rfc|exists:students,email',
          'usuario'  => [
              'required',
              'email:rfc',
              'exists:students,email',
              'exists:enrollments,email'
       ]

      ];
   }

    public function collection(Collection $rows)
    {

        foreach ($rows as $key=>$row)
        {

            $this->values = $row;

            $enroll = Enrollment::where('email', Str::lower(trim($row['usuario'])))
                ->where('code', trim($row['curso']))
                ->where('state', 1)
                ->first();

            if($enroll){

                $this->sum(true);
                 $enroll->update(['state' => self::DESMATRICULADO]);
            } else {
                $this->sum(false);
            }

        }
        return;
    }

   public function onError(\Throwable $e)
   {

       $this->count['processed']--;
       $this->count['mistakes']++;
       $array = $this->values;
       dd('OnError',$array,$e);
       $array['errors'] = [['el Usuario no esta matrículado en el curso o no existe']];
       $this->failures->add($array);
   }

    public $count = ['processed' => 0, 'mistakes' => 0];
    public function onFailure(Failure ...$failures)
    {
        //dd('OnError', $failures);
        // Handle the failures how you'd like.
        $this->failures = $this->failures->merge($failures);
        $rows=array();
        foreach ($failures as $failure) {
            array_push($rows,$failure->row()) ;
        }

        $this->count['mistakes']=( count(array_count_values($rows)));

    }

    public function failures()
    {
        return $this->failures;
    }

    protected function sum(bool $type)
    {
        if ($type) {
            $this->count['processed']++;

        } else {
            $this->count['mistakes']++;
        }
    }

}
