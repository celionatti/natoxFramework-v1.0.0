<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\helpers;

abstract class TimeFormat
{
    /**
     * TimeInAgo Function
     * 
     * This function makes Time Formats More Readable;
     * And Easy to Understand;
     *
     * @param [type] $timeStamp
     * @return mixed
     */
    public static function TimeInAgo($timeStamp)
    {
        date_default_timezone_set(TimeZone);

        $timestamp = strtotime($timeStamp) ? strtotime($timeStamp) : $timeStamp;

        $time = time() - $timestamp;

        switch ($time) {
                // Seconds
            case $time <= 60:
                return 'Just Now!';
                // Minutes
            case $time >= 60 && $time < 3600;
                return (round($time / 60) == 1) ? 'a month ago' : round($time / 60) . 'mins ago';
                // Hours
            case $time >= 3600 && $time < 86400;
                return (round($time / 3600) == 1) ? 'an hour ago' : round($time / 3600) . 'hours ago';
                // Days
            case $time >= 86400 && $time < 604800;
                return (round($time / 86400) == 1) ? 'a day ago' : round($time / 86400) . 'days ago';
                // Weeks
            case $time >= 604800 && $time < 2600640;
                return (round($time / 604800) == 1) ? 'a week ago' : round($time / 604800) . 'Weeks ago';
                // Months
            case $time >= 2600640 && $time < 31207680;
                return (round($time / 604800) == 1) ? 'a month ago' : round($time / 2600640) . 'Months ago';
                // Years
            case $time >= 31207680;
                return (round($time / 31207680) == 1) ? 'a year ago' : round($time / 31207680) . 'years ago';
        }
    }
}