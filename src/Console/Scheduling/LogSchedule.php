<?php

namespace PendoNL\LaravelScheduleLogger\Console\Scheduling;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

class LogSchedule extends Schedule
{

    private $rawCommand;

    /**
     * Add a new Artisan command event to the schedule.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return \Illuminate\Console\Scheduling\Event
     */
    public function command($command, array $parameters = [])
    {
        $this->rawCommand = $command;

        if (class_exists($command)) {
            $command = Container::getInstance()->make($command)->getName();
        }

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        $artisan = defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : 'artisan';

        return $this->exec("{$binary} {$artisan} {$command}", $parameters);
    }

    /**
     * Add a new command event to the schedule.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return \Illuminate\Console\Scheduling\Event
     */
    public function exec($command, array $parameters = [])
    {
        if (count($parameters)) {
            $command .= ' '.$this->compileParameters($parameters);
        }

        $this->events[] = $event = new LogEvent($command, $this->rawCommand);

        return $event;
    }

}
