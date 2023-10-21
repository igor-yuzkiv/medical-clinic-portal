<?php

namespace App\Utils;

use Illuminate\Support\Carbon;

/**
 *
 */
class TransformersUtil
{
    /**
     * @param Carbon $carbon
     * @return string
     */
    public static function dateTimeFormatted(Carbon $carbon): string
    {
        if ($carbon->diffInHours() >= 24) {
            return $carbon->format("d. M. Y h:i");
        } else {
            return $carbon->diffForHumans();
        }
    }
}
