<?php

namespace App\Charts;

use App\Enrollment;

/**
 * Libreria https://v6.charts.erik.cat/getting_started.html
 * Class EnrollmentChartMake
 * @package App\Charts
 */
class EnrollmentChartMake extends BaseChartMake
{
    /**
     * Initializes the chart.
     *
     * @return void
     */

   protected $model          = Enrollment::class;

   public function __construct()
   {
       parent::__construct();
   }

   public function getEnrollmentsForState($state)
   {
       return $this->getForState($state);
   }

   public function getAllEnrollmentsForYear()
   {
       return $this->getAllForYear();
   }

   public function getEnrollmentMonthCurrent()
   {
       return $this->getMonthCurrent();
   }

}
