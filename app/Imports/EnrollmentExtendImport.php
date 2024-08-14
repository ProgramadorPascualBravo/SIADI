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
            // Log iniciales
            Log::info('Procesando fila de datos', $row);
            Log::info('Fecha de nacimiento original:', ['fecha_de_nacimiento' => $row['fecha_de_nacimiento']]);

            $fecha_de_nacimiento = null;
            if (!empty($row['fecha_de_nacimiento'])) {
                try {
                    $fecha_de_nacimiento = Carbon::createFromFormat('d/m/Y', trim($row['fecha_de_nacimiento']))->format('Y-m-d');
                } catch (\Exception $e) {
                    $fecha_de_nacimiento = trim($row['fecha_de_nacimiento']);
                }
            }

            Log::info('Fecha de nacimiento después de la conversión (si aplica):', ['fecha_de_nacimiento' => $fecha_de_nacimiento]);

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
                    'fecha_de_nacimiento' => $fecha_de_nacimiento,
                ]);
            } else {
                // Preparar datos para actualizar, excluyendo los valores vacíos
                $dataToUpdate = array_filter([
                    'cellphone'         => trim($row['cellphone']),
                    'phone'             => trim($row['phone']),
                    'personalmail'      => trim($row['personalmail']),
                    'fecha_de_nacimiento' => $fecha_de_nacimiento,
                ]);

                // Actualizar datos existentes si hay algo que actualizar
                if (!empty($dataToUpdate)) {
                    $student->update($dataToUpdate);
                }
            }

            $studentInfo = $student->info;

            if (is_null($studentInfo)) {
                // Si no existe, crea uno nuevo
                $student->info()->create([
                    'plan_estudios' => trim($row['plan_estudios']),
                    'departamento'  => trim($row['departamento']),
                    'jornada'       => trim($row['jornada']),
                ]);
            } else {
                // Si existe, actualizar
                $studentInfo->update([
                    'plan_estudios' => trim($row['plan_estudios']),
                    'departamento'  => trim($row['departamento']),
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
        } catch (\Exception $e) {
            Log::error("Error procesando la fila:", ['error' => $e->getMessage(), 'row' => $row]);
            $this->failures->push(new Failure(
                $row['document'],
                $row['fecha_de_nacimiento'],
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
            '*.fecha_de_nacimiento' => 'nullable|date_format:Y-m-d', // Nueva validación
            '*.plan_estudios'     => 'required|string', // Nueva validación
            '*.departamento'      => 'required|string', // Nueva validación
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
