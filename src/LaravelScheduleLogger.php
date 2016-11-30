<?php

namespace PendoNL\LaravelScheduleLogger;

class LaravelScheduleLogger
{

    /**
     * Log the start of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function start($command_name) {
        return $this->log($command_name);
    }

    /**
     * Log the end of an event
     *
     * @param $command_name
     * @return mixed
     */
    public function end($command_name) {
        return $this->log($command_name);
    }

    /**
     * Save the event to the database
     *
     * @param $command_name
     * @return mixed
     */
    public function log($command_name) {
        $log = Schedulelog::where('end', NULL)->latest('id', 'DESC')->first();

        if(count($log) == 0) {

            return Schedulelog::create([
                'command_name' => $command_name,
                'start' => microtime(true)
            ]);

        } else {

            $log->end = microtime(true);
            $log->save();

            return $log;

        }

    }

}
