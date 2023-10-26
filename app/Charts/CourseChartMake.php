<?php


namespace App\Charts;


use App\Course;

/**
 * Libreria https://v6.charts.erik.cat/getting_started.html
 * Class CourseChartMake
 * @package App\Charts
 */
class CourseChartMake extends BaseChartMake
{
   protected $model        = Course::class;


   public function getGroupsForCourse()
   {
      $data = collect();
      foreach ($this->model::all() as $course) {
         $data->put($course->name, $course->groups()->count());
      }
      return $data;
   }

   public function getEnrollmentsForCourse()
   {
      $data = collect();
      foreach ($this->model::all() as $course) {
         $enrollments_active = 0;
         $enrollments_all = 0;
         foreach ($course->groups as $group) {
            $enrollments_active += $group->enrollments()->where('state', 'Matrículado')->get()->count();
            $enrollments_all += $group->enrollments()->get()->count();
         }
         $data->put($course->name, [
               $enrollments_active,
               $enrollments_all
            ]);
      }
      return $data;
   }
}