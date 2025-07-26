<?php

namespace MohamedHekal\LaravelFeatureBox\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled(string $feature, array $context = [])
 * @method static bool isDisabled(string $feature, array $context = [])
 * @method static bool enable(string $feature, array $conditions = [])
 * @method static bool disable(string $feature)
 * @method static array all()
 * @method static array|null get(string $feature)
 *
 * @see \MohamedHekal\LaravelFeatureBox\FeatureBox
 */
class FeatureBox extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'featurebox';
    }
}
