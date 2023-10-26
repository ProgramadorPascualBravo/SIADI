<?php


namespace App\Imports;


use App\Enrollment;
use App\Student;
use App\Traits\FailuresImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

/**
 * Libreria https://docs.laravel-excel.com/3.1/imports/
 * Class EnrollmentExtendImport
 * @package App\Imports
 */
class EnrollmentExtendImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use FailuresImport, Importable;

    /**
     * @var mixed
     */
    public $values;

    public function __construct()
    {
        $this->failures = new Collection();
    }

    public function model(array $row)
    {
        $this->values = $row;

        //Hasta aqui solo se valdio que email y documento son requeridos por separado
        $student = Student::where('email', $row['email'])
            ->where('document', $row['document'])
            ->first();

        if (is_null($student)) {

            Student::create([
                'name'      => Str::title(trim($row['name'])),
                'last_name' => Str::title(trim($row['last_name'])),
                'email'     => Str::lower(trim($row['email'])),
                'document'  => trim($row['document']),
                'password'  => md5(trim($row['document'])),
            ]);
        }

        $this->sum(true);
        return new Enrollment([
            'code'       => trim($row['code']),
            'rol'        => trim($row['rol']),
            'state'      => trim($row['state']),
            'email'      => trim($row['email']),
            'period'      => trim($row['period'])
        ]);
    }

    public function onError(\Throwable $e)
    {
        if ($this->count['processed'] > 0) {
          $this->count['processed']--;
        }
        $this->count['mistakes']++;
        $array = $this->values;
        $array['errors'] = [['Usuario matrículado en la asignatura.' . $e]];
        $this->failures->add($array);
    }

    public function rules(): array
    {
        //dd($this->values );
       return [
           '*.code'              => 'required|exists:groups,code',
           //'*.email'             => 'required|email:rfc|exists:students,email',
           '*.email'             => 'required|email:rfc',
           '*.rol'               => 'required|exists:roles_moodle,name',
           '*.state'             => 'required|exists:state_enrollments,id',
           '*.document'          => 'required|numeric',
           '*.name'              => 'required',
           '*.last_name'         => 'required',
           '*.period'            => 'required|numeric'
       ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($validator->getData() as $key=>$data) {

                $enroll = Enrollment::where('email', trim($data['email']))
                    ->where('code', trim($data['code']))
                    ->where('period', trim($data['period']))
                    ->where('state', trim($data['state']))
                    ->first();

                if ($enroll) {
                    $validator->errors()->add($key, 'La matricula ya existe');
                }

                $student = Student::where('email', trim($data['email']))
                    ->where('document', trim($data['document']))
                    ->first();

                if (is_null($student)) {

                    if (Student::where('document',trim($data['document']))->first()){
                        $validator->errors()->add($key, 'El Documento es unico y ya esta asociado a otro usuario');
                    }
                    if (Student::where('email', trim($data['email']))->first()){
                        $validator->errors()->add($key, 'El mail es unico y ya esta asiciado a otro usuario');
                    }
                }
            }
        });
    }
}
