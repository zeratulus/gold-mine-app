<?php

namespace App\Classes;

class WeightUnit
{
    const WU_TONS = 'T';

    const WU_KGS = 'kg';

    const WU_GRAMS = 'g';

    public static function intToWeight(int $number): string
    {
        return match ($number) {
            1 => self::WU_KGS,
            2 => self::WU_TONS,
            default => self::WU_GRAMS
        };
    }

    public static function getUserFriendlyWeight(int $weightGrams): string
    {
        $unit = self::WU_GRAMS;
        $weight = $weightGrams;

        $strLength = strlen((string)$weight);
        if ($strLength >= 7) {
            $unit = WeightUnit::WU_TONS;
            $weight = round($weight / 1000 / 1000, 2);
        }

        if ($strLength < 7 && $strLength >= 4) {
            $unit = WeightUnit::WU_KGS;
            $weight = round($weight / 1000, 2);
        }

        return "$weight $unit";
    }

}
