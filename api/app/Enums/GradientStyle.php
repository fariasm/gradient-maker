<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Linear()
 * @method static static Radial()
 */
final class GradientStyle extends Enum
{
    const Linear = 'Linear';
    const Radial = 'Radial';
}
