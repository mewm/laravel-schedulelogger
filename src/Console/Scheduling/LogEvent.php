<?php

namespace PendoNL\LaravelScheduleLogger\Console\Scheduling;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Mutex;

class LogEvent extends Event
{
    public function __construct(Mutex $mutex, string $command, string $rawCommand)
    {
        parent::__construct($mutex, $command);

        $this->mutex = $mutex;
        $this->command = $command;
        $this->output = $this->getDefaultOutput();

        $this->registerScheduleLogger($rawCommand);
    }

    public function registerScheduleLogger(string $command)
    {
        $this->before(function () use ($command) {
            app()->make('laravel-schedulelogger')->start($command);
        });

        $this->after(function () use ($command) {
            app()->make('laravel-schedulelogger')->end($command);
        });
    }
}
