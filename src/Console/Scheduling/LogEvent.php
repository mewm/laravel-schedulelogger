<?php

namespace PendoNL\LaravelScheduleLogger\Console\Scheduling;

use Illuminate\Console\Scheduling\Event;

class LogEvent extends Event
{

    /**
     * Create a new event instance.
     *
     * @param  string  $command
     */
    public function __construct($command)
    {
        $this->command = $command;
        $this->output = $this->getDefaultOutput();

        $this->registerScheduleLogger();
    }

    /**
     * Add the logger functions to the before and
     * after calls of the event.
     */
    function registerScheduleLogger()
    {
        $command = $this->command;

        $this->before(function() use($command) {
            app()->make('laravel-schedulelogger')->start($command);
        });

        $this->after(function() use($command) {
            app()->make('laravel-schedulelogger')->end($command);
        });
    }

}
