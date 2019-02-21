<?php

namespace PendoNL\LaravelScheduleLogger\Console\Scheduling;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

class LogSchedule extends Schedule
{
    /**
     * @var
     */
    private $rawCommand;

    /**
     * @param string $command
     * @param array  $parameters
     */
    public function command($command, array $parameters = [])
    {
        $this->rawCommand = $command;

        if (class_exists($command)) {
            $command = Container::getInstance()->make($command)->getName();
        }

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder())->find(false));
        $artisan = defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : 'artisan';

        return $this->exec("{$binary} {$artisan} {$command}", $parameters);
    }

    /**
     * @param string $command
     * @param array  $parameters
     */
    public function exec($command, array $parameters = []) 
    {
        if (count($parameters)) {
            $command .= ' '.$this->compileParameters($parameters);
        }

        $this->events[] = $event = new LogEvent($this->mutex, $command, $this->rawCommand);

        return $event;
    }
    
}
