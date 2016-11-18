<?php

namespace PendoNL\LaravelScheduleLogger;

class ScheduleLogger
{

    private $activeLogs = [];

    /**
     * Log the start of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function start($command_name) {
        $log = $this->log($command_name, 'start');

        $this->activeLogs[$command_name] = $log['id'];

        return $log;
    }

    /**
     * Log the end of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function end($command_name) {
        $log = $this->log($command_name, 'end');

        unset($this->log[$command_name]);

        return $log;
    }

    /**
     * Save the event to the database
     *
     * @param $command_name
     * @param $type
     * @return mixed
     */
    public function log($command_name, $type) {
        if(is_null($this->activeLogs[$command_name])) {
            return Schedulelog::create([
                'command_name' => $command_name,
                'type' => $type,
                'start' => microtime()
            ]);
        } else {
            $log = Schedulelog::find($this->activeLogs[$command_name]);
            $log->end = microtime();
            $log->save();

            return $log;
        }

    }

}
