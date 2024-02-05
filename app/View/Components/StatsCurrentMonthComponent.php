<?php

namespace App\View\Components;

use App\Course;
use App\Enrollment;
use App\Group;
use App\Program;
use App\Student;
use App\Traits\Months;
use App\User;
use Illuminate\Support\Str;
use Illuminate\View\Component;

/**
 * Componente https://laravel.com/docs/7.x/blade#components
 * Class StatsCurrentMonthComponent
 * @package App\View\Components
 */
class StatsCurrentMonthComponent extends Component
{
    use Months;

   /**
    * @var string[]
    */
    public $title;

    public $eloquent;

    public $route;

    protected $data = [
       'user' => [
         'class' => User::class
       ],
       'moodle' => [
          'class' => Student::class
       ],
       'program' => [
          'class' => Program::class
       ],
       'course' => [
          'class' => Course::class
       ],
       'group' => [
          'class' => Group::class
       ],
       'enrollment' => [
          'class' => Enrollment::class
       ],
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->route       = $type. '-report';
        $this->title       = Str::title(__('modules.'.$type.'.name'));
        $this->eloquent    = $this->data[$type]['class'];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.stats-current-month');
    }

    static function getMonth($month)
    {
       return self::$months[$month];
    }
}
