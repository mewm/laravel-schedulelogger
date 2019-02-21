<?php

namespace PendoNL\LaravelScheduleLogger;

class LaravelScheduleLogger
{
    /**
     * @string
     */
    private $memoryUsageOnStart;


    public function start(string $commandName): ScheduleLog
    {
        return $this->log($commandName);
    }


    public function end(string $commandName): ScheduleLog
    {
        return $this->log($commandName);
    }


    public function log(string $commandName): ScheduleLog
    {
        $log = ScheduleLog::getLatest();

        if ($log === null) {
            $this->memoryUsageOnStart = memory_get_usage(false);

            return ScheduleLog::initiate($commandName);
        }

        $memoryPeak = (memory_get_peak_usage(false) - $this->memoryUsageOnStart) / 1024 / 1024;

        $log->end($memoryPeak);

        return $log;
    }


    public function getExecutionTime(ScheduleLog $log)
    {
        return $log->end - $log->start;
    }
}
