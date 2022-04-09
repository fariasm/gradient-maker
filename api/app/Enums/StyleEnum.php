<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

final class StyleEnum extends Enum
{
    static function values(): array
    {
        return [
            'linear' => 'Linear',
            'radial' => 'Radial'
        ];
    }
}
