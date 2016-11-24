<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Support\ServiceProvider;

/**
 * Class ScheduleLoggerServiceProvider.
 */
class ScheduleLoggerServiceProvider extends ServiceProvider
{
    /**
     * Publishes the config file.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the migration if it does not exists
        if (! class_exists('CreateSchedulelogsTable')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/create_schedulelogs_table.php.stub' => database_path('migrations/'.$timestamp.'_create_schedulelogs_table.php'),
            ], 'migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(
            'Illuminate\Console\Scheduling\Schedule', $schedule = new \PendoNL\LaravelScheduleLogger\Console\Scheduling\LogSchedule
        );

        $this->app->singleton('laravel-schedulelogger', function () {
            return new \PendoNL\LaravelScheduleLogger\LaravelScheduleLogger;
        });
    }
}
