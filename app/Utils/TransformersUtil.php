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

    /**
     * @param string|null $value
     * @return string
     */
    public static function getInitials(?string $value = null): string {
        if (!$value) {
            return '';
        }

        $name = explode(' ', $value);
        $initials = '';
        foreach ($name as $n) {
            $initials .= mb_substr($n, 0, 1);

            if (mb_strlen($initials) == 2) {
                break;
            }
        }
        return $initials;
    }
}
