<?php

namespace App\Helpers;

class EvaluationHelper
{
    public static function totalFromArrays(array $values, array $weights)
    {
        $sum = 0;
        foreach ($values as $key => $value)
            $sum += $value * $weights[$key];
        return $sum / array_sum($weights);
    }

    public static function totalFromModels(array $criteriaEvaluations)
    {
        $values = [];
        $weights = [];
        $i = 0;
        foreach ($criteriaEvaluations as $ce) {
            $values[$i] = $ce->value;
            $weights[$i] = $ce->criteria->impact;
            $i++;
        }
        return self::totalFromArrays($values, $weights);
    }

    public static function formatTotal(float|null $total)
    {
        if ($total == null)
            $total = 0.0;
        return sprintf('%.2f', $total);
    }
}
