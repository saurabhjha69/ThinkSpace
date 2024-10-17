<?php // Code within app\Helpers\Helper.php

namespace App\Helper;

use Carbon\Carbon;

class Helper
{
    public static function secondsToMinutes(int $seconds): string
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        return sprintf("%d:%02d", $minutes, $seconds);
    }
    public static function secondsToMinutesForGraph(int $seconds): float
    {
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        // Convert remaining seconds to fraction of a minute and add to minutes
        return round($minutes + ($remainingSeconds / 60),2);
    }

    public static function formatDateTime($dateTime)
    {
        return \Carbon\Carbon::parse($dateTime)->format('j F, Y - g:i A');
    }

    public static function calculatePercentage($obtainedMarks, $totalMarks)
    {
        if ($totalMarks == 0) {
            return 0; // Avoid division by zero
        }

        return ($obtainedMarks / $totalMarks) * 100;
    }

    public static function secondsToHoursMinutes($seconds)
    {
        $hours = floor($seconds / 3600); // Get the number of hours
        $minutes = round(($seconds % 3600) / 60); // Get the remaining minutes

        // Ensure two-digit format for minutes (e.g., '00' instead of '0')
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $hours . ':' . $minutes;
    }
    public static function secondsToHrsForGraph($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%02d:%02d', $hours, $minutes);
    }



public static function timeLeft($dateTime)
{

    $targetTime = Carbon::parse($dateTime);
    $currentTime = Carbon::now();


    if ($targetTime->isPast()) {
        return true;
    }

    // Get the difference in a human-readable format
    $difference = $currentTime->diffForHumans($targetTime, [
        'parts' => 4,
        'short' => true,
        'syntax' => Carbon::getDays()
    ]);

    return $difference;
}

}
