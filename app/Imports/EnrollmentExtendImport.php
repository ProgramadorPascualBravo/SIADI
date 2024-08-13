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
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

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

        // Verifica si el estudiante ya existe
        $student = Student::where('email', $row['email'])
            ->where('document', $row['document'])
            ->first();

        if (is_null($student)) {
            // Crea un nuevo estudiante si no existe
            $student = Student::create([
                'name'              => Str::title(trim($row['name'])),
                'last_name'         => Str::title(trim($row['last_name'])),
                'email'             => Str::lower(trim($row['email'])),
                'cellphone'         => trim($row['cellphone']),
                'phone'             => trim($row['phone']),
                'personalmail'      => trim($row['personalmail']),
                'document'          => trim($row['document']),
                'password'          => md5(trim($row['document'])),
                'fecha_de_nacimiento' => trim($row['fecha_de_nacimiento']), // Agregar fecha de nacimiento
            ]);
        } else {
            // Preparar datos para actualizar, excluyendo los valores vacíos
            $dataToUpdate = array_filter([
                'cellphone'         => trim($row['cellphone']),
                'phone'             => trim($row['phone']),
                'personalmail'      => trim($row['personalmail']),
                'fecha_de_nacimiento' => trim($row['fecha_de_nacimiento']), // Actualizar fecha de nacimiento
            ]);

            // Actualizar datos existentes si hay algo que actualizar
            if (!empty($dataToUpdate)) {
                $student->update($dataToUpdate);
            }
        }

        // Manejar la información adicional del estudiante en la tabla `student_info`
        $studentInfo = $student->info; // Asumiendo que la relación se llama 'info'

        if (is_null($studentInfo)) {
            // Si no existe, crea uno nuevo
            $student->info()->create([
                'plan_estudios' => trim($row['plan_estudios']),
                'departamento'  => trim($row['departamento']),
                'programa'      => trim($row['programa']),
                'jornada'       => trim($row['jornada']),
            ]);
        } else {
            // Si existe, actualizar
            $studentInfo->update([
                'plan_estudios' => trim($row['plan_estudios']),
                'departamento'  => trim($row['departamento']),
                'programa'      => trim($row['programa']),
                'jornada'       => trim($row['jornada']),
            ]);
        }

        $this->sum(true);

        return new Enrollment([
            'code'         => trim($row['code']),
            'rol'          => trim($row['rol']),
            'state'        => trim($row['state']),
            'email'        => trim($row['email']),
            'period'       => trim($row['period']),
            'cellphone'    => trim($row['cellphone']),
            'phone'        => trim($row['phone']),
            'personalmail' => trim($row['personalmail']),
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
        return [
            '*.code'              => 'required|exists:groups,code',
            '*.email'             => 'required|email:rfc',
            '*.rol'               => 'required|exists:roles_moodle,name',
            '*.state'             => 'required|exists:state_enrollments,id',
            '*.document'          => 'required|numeric',
            '*.name'              => 'required',
            '*.last_name'         => 'required',
            '*.period'            => 'required|numeric',
            '*.fecha_de_nacimiento' => 'nullable|date', // Nueva validación
            '*.plan_estudios'     => 'required|string', // Nueva validación
            '*.departamento'      => 'required|string', // Nueva validación
            '*.programa'          => 'required|string', // Nueva validación
            '*.jornada'           => 'required|string', // Nueva validación
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($validator->getData() as $key => $data) {

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

                    if (Student::where('document', trim($data['document']))->first()) {
                        $validator->errors()->add($key, 'El Documento es unico y ya esta asociado a otro usuario');
                    }
                    if (Student::where('email', trim($data['email']))->first()) {
                        $validator->errors()->add($key, 'El mail es unico y ya esta asiciado a otro usuario');
                    }
                }
            }
        });
    }
}
