<?php

namespace PendoNL\LaravelScheduleLogger;

class ScheduleLogger
{

    /**
     * Log the start of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function start($command_name) {
        return $this->log($command_name, 'start');
    }

    /**
     * Log the end of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function end($command_name) {
        return $this->log($command_name, 'end');
    }

    /**
     * Save the event to the database
     *
     * @param $command_name
     * @param $type
     * @return mixed
     */
    public function log($command_name, $type) {
        return Schedulelog::create([
            'command_name' => $command_name,
            'type' => $type
        ]);
    }

}
