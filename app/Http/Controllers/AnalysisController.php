<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Helper\Helper;
use App\Charts\SubmoduleWatchHoursChart;

class AnalysisController extends Controller
{
    public function singleCourse(Course $course,SubmoduleWatchHoursChart $chart ){
        $submoduleWatchDuration = $course->subModulesWatchDuration();
        $submoduleTitles = $submoduleWatchDuration->pluck('video_name')->toArray();
        $watchHours = $submoduleWatchDuration->pluck('total_watch_hours')
                                                        ->map(function($watchHrs){
                                                            return Helper::secondsToMinutesForGraph($watchHrs);
                                                        })
                                                        ->toArray();
        $subModuleWatchHoursChart = $chart->buildChart($submoduleTitles,$watchHours);

        return view('analytics.course',['course'=>$course,'subModuleWatchHoursChart'=>$subModuleWatchHoursChart]);
    }
}
