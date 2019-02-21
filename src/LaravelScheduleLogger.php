<?php

namespace PendoNL\LaravelScheduleLogger;

class LaravelScheduleLogger
{
    /**
     * @string
     */
    private $memoryUsageOnStart;


    public function start(string $commandName)
    {
        return $this->log($commandName);
    }


    public function end(string $commandName)
    {
        return $this->log($commandName);
    }


    public function log(string $commandName): Schedulelog
    {
        $log = Schedulelog::getLatest();

        if ($log === null) {
            $this->memoryUsageOnStart = memory_get_usage(false);

            return Schedulelog::initiate($commandName);
        }

        $memoryPeak = (memory_get_peak_usage(false) - $this->memoryUsageOnStart) / 1024 / 1024;

        $log->end();

        return $log;
    }


    public function getExecutionTime(Schedulelog $log)
    {
        return $log->end - $log->start;
    }
}
