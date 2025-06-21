<?php

namespace App\Helpers;

class EventHelper
{
    const MONTHS = [
        1 => 'january',
        2 => 'february',
        3 => 'march',
        4 => 'april',
        5 => 'may',
        6 => 'june',
        7 => 'july',
        8 => 'august',
        9 => 'september',
        10 => 'october',
        11 => 'november',
        12 => 'december',
    ];

    public static function monthsLang(): array
    {
        $months = [];
        foreach (self::MONTHS as $id => $suffix) {
            $months[$id] = __("events.$suffix");
        }
        return $months;
    }

    public static function monthLang(int $month): string
    {
        $suffix = self::MONTHS[$month];
        return __("events.$suffix");
    }
}
