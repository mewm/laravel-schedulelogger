<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Support\ServiceProvider;

class LaravelScheduleLoggerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!class_exists('CreateSchedulelogsTable')) {
            $timestamp = date('Y_m_d_His');
            $this->publishes([
                __DIR__.'/../database/migrations/create_schedulelogs_table.php.stub' => database_path('migrations/'.$timestamp.'_create_schedulelogs_table.php'),
            ], 'migrations');
        }
    }

    public function register() : void
    {
        $this->app->singleton('laravel-schedulelogger', function () {
            return new \PendoNL\LaravelScheduleLogger\LaravelScheduleLogger();
        });

        $this->app->bind('command.schedulelogger:clean', \PendoNL\LaravelScheduleLogger\Commands\CleanCommand::class);

        $this->commands([
            'command.schedulelogger:clean',
        ]);
    }
}
