<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SubmoduleWatchHoursChart
{

    protected $chart;
    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function buildChart(array $submoduleTitles, array $watchHours)
    {
        return $this->chart->barChart()
            ->setTitle('Video Watch Duration In Minutes')
            ->setXAxis($submoduleTitles)
            ->addData('Time in Mins', $watchHours)
            ->setColors(['#925fe2'])
            ->setHeight(350);
    }
}
