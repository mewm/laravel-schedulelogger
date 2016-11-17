<?php

namespace PendoNL\LaravelScheduleLogger;

/**
 * Class Facade.
 *
 * @method static string icon(string $icon, array $options = [])
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-schedulelogger';
    }
}
