<?php

namespace PendoNL\LaravelScheduleLogger\Console\Commands;

use PendoNL\LaravelScheduleLogger\Console\Scheduling\LogSchedule;
use Illuminate\Console\Scheduling\ScheduleRunCommand as Command;

class ScheduleRunCommand extends Command
{
    /**
     * Create a new command instance.
     *
     * @param  LogSchedule $schedule
     */
    public function __construct(LogSchedule $schedule)
    {
        $this->schedule = $schedule;

        parent::__construct();
    }

}
