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

}
