<?php

namespace App\Helpers;

use Carbon\Carbon;

class NumberGenerator
{
    public const RESET_TYPE_YEARLY = 1;

    public const RESET_TYPE_MONTHLY = 2;
    
    public const RESET_TYPE_DAILY = 3;

    public const SEPARATOR = '-';


    public static function generate(
        $code,
        $className,
        $zeroPad = 3,
        $resetType = self::RESET_TYPE_YEARLY
    ) {
        $dateTime = Carbon::now();
        $day_now = $dateTime->day;
        $month_now = $dateTime->month;
        $year_now = $dateTime->year;

        $lastModel = app($className)::withTrashed()->select('number')
            ->when(self::RESET_TYPE_YEARLY == $resetType, function ($query) use ($year_now) {
                $query->whereYear('created_at', '=', $year_now);
            })
            ->orderBy('id', 'DESC')
            ->first();

        if (!empty($lastModel)) {
            $lastNumber = intval(explode(self::SEPARATOR, $lastModel->number)[2]);
        } else {
            $lastNumber = 0;
        }

        // Get Current Number
        $currentNumber = strval($lastNumber + 1);
        $currentNumber = str_pad($currentNumber, $zeroPad, '0', STR_PAD_LEFT);

        // Generate Format Number
        $formattedNumber = "$code".self::SEPARATOR."$year_now"."$month_now"."$day_now".self::SEPARATOR."$currentNumber";

        return $formattedNumber;
    }
}
