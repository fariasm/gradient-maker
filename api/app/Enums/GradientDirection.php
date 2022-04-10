<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Top()
 * @method static static TopRight()
 * @method static static Right()
 * @method static static BottomRight()
 * @method static static Bottom()
 * @method static static BottomLeft()
 * @method static static Left()
 * @method static static TopLeft()
 */
final class GradientDirection extends Enum
{
    const Top = 'Top';
    const TopRight = 'Top right';
    const Right = 'Right';
    const BottomRight = 'Bottom right';
    const Bottom = 'Bottom left';
    const Left = 'Left';
    const TopLeft = 'Top left';
}
