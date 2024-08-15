<?php

namespace App\Imports;

use App\Enrollment;
use App\Student;
use App\Models\StudentInfo;
use App\Traits\FailuresImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

        try {
            Log::info('Procesando fila de datos', $row);
            Log::info('Fecha de nacimiento original:', ['fecha_de_nacimiento' => $row['fecha_de_nacimiento']]);

            $fecha_de_nacimiento = null;

            if (!empty($row['fecha_de_nacimiento'])) {
                if (is_numeric($row['fecha_de_nacimiento']) && strlen($row['fecha_de_nacimiento']) == 8) {
                    $fecha_de_nacimiento = Carbon::createFromFormat('Ymd', trim($row['fecha_de_nacimiento']))->format('Y-m-d');
                } elseif (is_numeric($row['fecha_de_nacimiento'])) {
                    $fecha_de_nacimiento = Carbon::parse('1900-01-01')->addDays($row['fecha_de_nacimiento'] - 2)->format('Y-m-d');
                } else {
                    $fecha_de_nacimiento = Carbon::parse(trim($row['fecha_de_nacimiento']))->format('Y-m-d');
                }
            }

            Log::info('Fecha de nacimiento después de la conversión (si aplica):', ['fecha_de_nacimiento' => $fecha_de_nacimiento]);

            $student = Student::where('email', $row['email'])
                ->where('document', $row['document'])
                ->first();

            if (is_null($student)) {
                $student = Student::create([
                    'name'              => Str::title(trim($row['name'])),
                    'last_name'         => Str::title(trim($row['last_name'])),
                    'email'             => Str::lower(trim($row['email'])),
                    'cellphone'         => trim($row['cellphone']),
                    'phone'             => trim($row['phone']),
                    'personalmail'      => trim($row['personalmail']),
                    'document'          => trim($row['document']),
                    'password'          => md5(trim($row['document'])),
                    'fecha_de_nacimiento' => $fecha_de_nacimiento,
                ]);

                StudentInfo::create([
                    'document'      => trim($row['document']),
                    'plan_estudios' => trim($row['plan_estudios']),
                    'departamento'  => trim($row['departamento']),
                    'jornada'       => trim($row['jornada']),
                    'code'          => trim($row['code']),
                ]);
            } else {
                $dataToUpdate = array_filter([
                    'cellphone'         => trim($row['cellphone']),
                    'phone'             => trim($row['phone']),
                    'personalmail'      => trim($row['personalmail']),
                    'fecha_de_nacimiento' => $fecha_de_nacimiento,
                ]);

                if (!empty($dataToUpdate)) {
                    $student->update($dataToUpdate);
                }

                $studentInfo = StudentInfo::where('document', $student->document)->first();

                if ($studentInfo->code !== trim($row['code'])) {
                    StudentInfo::create([
                        'document'      => trim($row['document']),
                        'plan_estudios' => trim($row['plan_estudios']),
                        'departamento'  => trim($row['departamento']),
                        'jornada'       => trim($row['jornada']),
                        'codigo_matricula'  => trim($row['code']),
                    ]);
                } else {
                    Log::info('El código es el mismo, no se requiere actualización en student_info.');
                }
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
        } catch (\Exception $e) {
            Log::error("Error procesando la fila:", ['error' => $e->getMessage(), 'row' => $row]);
            $this->failures->push(new Failure(
                $row['document'],
                'import',
                [$e->getMessage()],
                $row
            ));
        }
    }

    public function onError(\Throwable $e)
    {
        Log::error("Error general:", ['error' => $e->getMessage()]);
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
            '*.fecha_de_nacimiento' => 'required',
            '*.plan_estudios'     => 'required|string',
            '*.departamento'      => 'required|string',
            '*.jornada'           => 'required|string',
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
                        $validator->errors()->add($key, 'El Documento es único y ya está asociado a otro usuario');
                    }
                    if (Student::where('email', trim($data['email']))->first()) {
                        $validator->errors()->add($key, 'El mail es único y ya está asociado a otro usuario');
                    }
                }
            }
        });
    }
}
