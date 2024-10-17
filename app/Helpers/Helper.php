<?php // Code within app\Helpers\Helper.php

namespace App\Helper;

class Helper
{
    public static function secondsToMinutes(int $seconds): string
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        return sprintf("%d:%02d", $minutes, $seconds);
    }
}