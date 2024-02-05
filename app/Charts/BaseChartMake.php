<?php
namespace App\Charts;
use App\Traits\Months;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;

/**
 * Libreria https://v6.charts.erik.cat/getting_started.html
 * Class BaseChartMake
 * @package App\Charts
 */
class BaseChartMake extends Chart
{
   use Months;

   protected $model;

   public function __construct()
   {
      parent::__construct();
   }

   public function getMonthCurrent()
   {
      return $this->model::month()->get()->count();
   }

   public function getTotal()
   {
      return $this->model::all()->count();
   }

   public function getAllForYear()
   {
      $items = $this->model::query()->whereYear('created_at', Carbon::now()->year)->orderBy('created_at')->get()->groupBy(function($item) {
         return $item->created_at->format('m');
      })->map(function ($item) {
         return count($item);
      });
      $organized = $this->organizeDataByMonth($items);

      return $organized;
   }

   public function getForState($state)
   {
      $items = $this->model::query()
         ->where('state', $state)
         ->whereYear('created_at', Carbon::now()->year)
         ->orderBy('created_at')->get()->groupBy(function($item) {
            return $item->created_at->format('m');
         })->map(function ($item) {
            return count($item);
         });
      $organized = $this->organizeDataByMonth($items);

      return $organized;
   }

   public static function newChart()
   {
      return new static();
   }

}