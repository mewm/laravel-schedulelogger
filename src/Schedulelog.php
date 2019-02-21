<?php

namespace PendoNL\LaravelScheduleLogger;

use Illuminate\Database\Eloquent\Model;

class Schedulelog extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['command_name', 'start',];

    /**
     * @var bool
     */
    public $timestamps = true;


    public function end(float $memoryPeak): void
    {
        $end                          = microtime(true) * 1000;
        $this->memory_usage           = $memoryPeak;
        $this->end                    = $end;
        $this->execution_time_seconds = $end - $this->start / 1000;
        $this->save();
    }


    public function getLatest(): ?self
    {
        return self::where('end', null)->latest('id', 'DESC')->first();
    }


    public function initiate(string $commandName): self
    {
        return self::create([
            'command_name' => $commandName,
            'start'        => microtime(true) * 1000,
        ]);
    }
}
