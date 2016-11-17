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
        $this->before(function($this) {
            ScheduleLogger::start($this->command);
        });

        $this->after(function($this) {
            ScheduleLogger::end($this->command);
        });
    }

}
