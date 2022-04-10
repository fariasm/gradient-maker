<?php

namespace App\Rules;

use App\Enums\ColorFormat;
use Faker\Core\Color;
use Illuminate\Contracts\Validation\Rule;

class ColorFormatRule implements Rule
{   
    const HEX_REGEX = '/#([a-f0-9]{3}){1,2}\b/';
    const RGB_REGEX = '/rgb\((\d{1,3}), (\d{1,3}), (\d{1,3})\)/';

    private $colorFormat = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($colorFormat)
    {
        $this->colorFormat = $colorFormat;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = false;
        if($this->colorFormat == ColorFormat::Hex)
        {
            $result = preg_match(self::HEX_REGEX, $value) == 1;
        }
        if($this->colorFormat == ColorFormat::Rgb)
        {
            $result = preg_match(self::RGB_REGEX, $value) == 1;
        }
        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid.';
    }
}
