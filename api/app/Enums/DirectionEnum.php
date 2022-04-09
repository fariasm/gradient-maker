<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

final class DirectionEnum extends Enum
{
    static function values(): array
    {
        return [
            'top' => 'Top',
            'top-right' => 'Top right',
            'right' => 'Right',
            'bottom-right' => 'Bottom right',
            'bottom' => 'Bottom',
            'bottom-left' => 'Bottom left',
            'left' => 'Bottom left',
            'top-left' => 'Top left'
        ];
    }
}
