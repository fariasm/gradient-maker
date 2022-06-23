<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Hex()
 * @method static static Rgb()
 */
final class ColorFormat extends Enum
{
    public const Hex = 'Hex';
    public const Rgb = 'Rgb';
}
