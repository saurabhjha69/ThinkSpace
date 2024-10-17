<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyCourseSaleChart
{
    protected $saleschart;

    public function __construct(LarapexChart $saleschart)
    {
        $this->saleschart = $saleschart;
    } 
   
    public function build(array $salesData, array $courseNames)
    {
        return $this->saleschart->barChart() // You can also use lineChart or pieChart
            ->setTitle('Top 5 course')
            ->addData('Sales', $salesData) // Dynamic sales data
            ->setXAxis($courseNames) // Dynamic course names
            ->setColors(['#8354CB']);
    }
}
