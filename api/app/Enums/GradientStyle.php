<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Linear()
 * @method static static Radial()
 */
final class GradientStyle extends Enum
{
    public const Linear = 'Linear';
    public const Radial = 'Radial';
}
