<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DISABLED()
 * @method static self ENABLE()
 *
 */
final class ActiveStatus extends Enum
{
    protected static function labels(): array
    {
        return [
            'DISABLED' => 'Disabled',
            'ENABLE' => 'Enable',
        ];
    }

    protected static function values(): array
    {
        return [
            'DISABLED' => 0,
            'ENABLE' => 1,
        ];
    }
}
