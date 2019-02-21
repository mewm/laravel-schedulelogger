<?php

namespace PendoNL\LaravelScheduleLogger;

/**
 * @method static string icon(string $icon, array $options = [])
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'laravel-schedulelogger';
    }
}
