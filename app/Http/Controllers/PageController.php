<?php

namespace App\Http\Controllers;

use App\Charts\CourseChartMake;
use App\Charts\EnrollmentChartMake;
use App\Charts\StudentMoodleChartMake;
use App\Enrollment;
use App\Exports\reportExport;
use App\StateEnrollment;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Str;

class PageController extends Controller
{

    public function index()
    {

        return view('index');
    }

    public function singin(Request $request)
    {
        $request->validate([
            'username' => 'required|email:rfc|exists:users,username,state,1',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            Log::channel('trail')->info(
               'El usuario ingreso al sistema SIADI', ['usuario' => Auth::user()->username]
            );
            return redirect()->intended('dashboard');
        }
       Log::channel('trail')->info(
          'El usuario no pudo iniciar sesión', ['usuario' => $request->get('username')]
       );
        return redirect(route('login'))->withErrors(['failed' => 'Estas credenciales no coinciden con nuestros registros. ']);
    }

    public function logout ()
    {
        Log::channel('trail')->info(
            'El usuario salio del sistema SIADI', ['usuario' => Auth::user()->username]
        );
        Auth::logout();
        Session::flush();
        return redirect(route('login'));
    }

    public function verify($code)
    {
       $user = User::where('confirmation_code', $code)->first();
       if (! is_null($user)) {
         $user->email_verified_at = Carbon::now('America/Bogota')->toDateTimeString();
         $user->verified = 1;
         $user->save();
         Auth::login($user);
         Log::channel('trail')->info(
             'El usuario verifico el correo en el sistema SIADI', ['usuario' => Auth::user()->username]
         );
         return redirect()->intended('dashboard');
       }
       Log::channel('trail')->warning(
          'El usuario no pudo verifico el correo en el sistema SIADI, No código valido', ['usuario' => Auth::user()->username]
       );
       return view('email_verified.error');
    }

    public function reportStudent()
    {
       Log::channel('trail')->info(
          'El usuario ingreso al módulo de estadisticas de usuarios plataforma en el sistema SIADI', ['usuario' => Auth::user()->username]
       );
       $chart_total = StudentMoodleChartMake::newChart();
       $chart_total->title(Str::ucfirst('Total de '.__('modules.moodle.name')));
       $chart_total->labels(["Total", "Mes"]);
       $chart_total->options(collect([
          'chart' => [
             'plotBackgroundColor' => null,
             'plotBorderWidth' => null,
             'plotShadow' => false,
             'type' => 'pie',
          ],
          'plotOptions' => [
             'pie' => [
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => [
                   'enabled'=> true,
                   'format' => "<b>{point.name}</b>: {point.percentage:.1f} %"
                ],
             ],
          ],
          'series' => [
             [
                'name' =>  'Matrículas',
                'colorByPoint' => true,
                'data' => [
                   [
                      'name' => 'Total',
                      'y' => $chart_total->getTotal(),
                   ], [
                      'name' => 'Mes',
                      'y' => $chart_total->getMonthCurrent()
                   ]
                ]
             ]
          ]
       ]));
       $chart_total->dataset(Str::ucfirst('total'), 'pie', [$chart_total->getTotal()]);

       $chart_state = StudentMoodleChartMake::newChart();
       $chart_state->label('Usuarios creados');
       $chart_state->title('Usuarios creados por mes del año '. now()->year);
       $chart_state->labels($chart_state->getMonths());
       $chart_state->dataset(Str::title(__('modules.moodle.name')), 'column', $chart_state->getAllStudentForMonthForState()->values());
       return view('report.student', ['chartstate' => $chart_state, 'charttotal' => $chart_total]);
    }

    public function reportEnrollment()
    {
       Log::channel('trail')->info(
          'El usuario ingreso al módulo de estadisticas de matriculas en el sistema SIADI', ['usuario' => Auth::user()->username]
       );
       $chart_total = EnrollmentChartMake::newChart();
       $chart_total->title(Str::ucfirst('Total de '.__('modules.enrollment.name')));
       $chart_total->labels(["Total", "Mes"]);
       $chart_total->options(collect([
          'chart' => [
             'plotBackgroundColor' => null,
             'plotBorderWidth' => null,
             'plotShadow' => false,
             'type' => 'pie',
          ],
          'plotOptions' => [
             'pie' => [
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => [
                   'enabled'=> true,
                   'format' => "<b>{point.name}</b>: {point.percentage:.1f} %"
                ],
             ],
          ],
          'series' => [
             [
                'name' =>  'Matrículas',
                'colorByPoint' => true,
                'data' => [
                   [
                      'name' => 'Total',
                      'y' => $chart_total->getTotal(),
                   ], [
                      'name' => 'Mes',
                      'y' => $chart_total->getMonthCurrent()
                   ]
                ]
             ]
          ]
       ]));
       $chart_total->dataset(Str::ucfirst('total'), 'pie', [$chart_total->getTotal()]);


       $chart_state = EnrollmentChartMake::newChart();
       $chart_state->label('Matrículas');
       $chart_state->title("Matrículas por mes en el año ". now()->year);
       $chart_state->labels($chart_state->getMonths());
       $chart_state->dataset(Str::title(__('modules.enrollment.name')), 'area', $chart_state->getAllEnrollmentsForYear()->values());
       foreach (StateEnrollment::all(['id', 'name']) as $state) {
          $chart_state->dataset(Str::title($state->name), 'column', $chart_state->getEnrollmentsForState($state->id)->values());
       }
       $chart_state->height = 600;
       return view('report.enrollment', [
          'chartstate' => $chart_state,
          'charttotal' => $chart_total,
          'states'     =>  StateEnrollment::all()
       ]);
    }

    public function reportCourse()
    {
       Log::channel('trail')->info(
          'El usuario ingreso al módulo de estadisticas de asignaturas en el sistema SIADI', ['usuario' => Auth::user()->username]
       );

             /***/
       $chart_total = CourseChartMake::newChart();
       $chart_total->title(Str::ucfirst('Total de '.__('modules.course.name')));
       $chart_total->labels(["Total", "Mes"]);
       $chart_total->options(collect([
          'chart' => [
             'plotBackgroundColor' => null,
             'plotBorderWidth' => null,
             'plotShadow' => false,
             'type' => 'pie',
          ],
          'plotOptions' => [
            'pie' => [
               'allowPointSelect' => true,
               'cursor' => 'pointer',
               'dataLabels' => [
                  'enabled'=> true,
                  'format' => "<b>{point.name}</b>: {point.percentage:.1f} %"
               ],
            ],
          ],
          'series' => [
             [
               'name' =>  'Asignaturas',
               'colorByPoint' => true,
               'data' => [
                  [
                     'name' => 'Total',
                     'y' => $chart_total->getTotal(),
                  ], [
                     'name' => 'Mes',
                     'y' => $chart_total->getMonthCurrent()
                  ]
               ]
             ]
          ]
        ]));
       $chart_total->dataset(Str::ucfirst('total'), 'pie', [$chart_total->getTotal()]);

       /**/

       $chart_year = CourseChartMake::newChart();
       $chart_year->title( Str::ucfirst(__('modules.course.pname') .' creadas por mes del año '.now()->year));
       $chart_year->label('Asignaturas');
       $chart_year->labels($chart_year->getMonths());
       $chart_year->dataset(Str::ucfirst('Total'), 'area', $chart_year->getAllForYear()->values());
       $chart_year->height = 500;
       /**/

       $chart_enrollment = CourseChartMake::newChart();
       $chart_enrollment->label('Matrículas');
       $chart_enrollment->height = 500;
       $chart_enrollment->title('Matrículas totales y activas por asignatura');
       $course_enrollment = $chart_enrollment->getEnrollmentsForCourse();
       $chart_enrollment->labels($course_enrollment->keys());
       $m = [];
       $t = [];
       foreach ($course_enrollment->keys() as $course) {
          array_push($t, $course_enrollment->get($course)[1]);
          array_push($m, $course_enrollment->get($course)[0]);
       }
       $chart_enrollment->dataset('Total', 'column', $t);
       $chart_enrollment->dataset('Matrículas activas', 'column', $m);

       return view('report.course', [
          'charttotal'        => $chart_total,
          'chartyear'         => $chart_year,
          'chartenrollment'   => $chart_enrollment
       ]);
    }
}
