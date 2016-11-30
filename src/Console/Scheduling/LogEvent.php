<?php

namespace PendoNL\LaravelScheduleLogger\Console\Scheduling;

use Illuminate\Console\Scheduling\Event;

class LogEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @param string $command
     * @param string $rawCommand
     */
    public function __construct($command, $rawCommand)
    {
        $this->command = $command;
        $this->output = $this->getDefaultOutput();

        $this->registerScheduleLogger($rawCommand);
    }

    /**
     * Add the logger functions to the before and
     * after calls of the event.
     */
    public function registerScheduleLogger($command)
    {
        $this->before(function () use ($command) {
            app()->make('laravel-schedulelogger')->start($command);
        });

        $this->after(function () use ($command) {
            app()->make('laravel-schedulelogger')->end($command);
        });
    }
}
