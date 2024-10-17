<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyUsersChart     
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    } 
   
    public function build(array $data, array $labels)
    {
        return $this->chart->pieChart()
            ->setTitle('User Roles')
            ->addData($data)
            ->setLabels($labels)
            ->setColors(['#603C98','#8354CB', '#A578E7', '#CAAAF8']);
    }
}
