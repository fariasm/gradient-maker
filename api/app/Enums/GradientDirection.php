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
    public const Top = 'Top';
    public const TopRight = 'Top right';
    public const Right = 'Right';
    public const BottomRight = 'Bottom right';
    public const Bottom = 'Bottom';
    public const BottomLeft = 'Bottom left';
    public const Left = 'Left';
    public const TopLeft = 'Top left';
}
