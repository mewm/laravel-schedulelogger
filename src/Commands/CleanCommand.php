<?php

namespace PendoNL\LaravelScheduleLogger\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use PendoNL\LaravelScheduleLogger\Schedulelog;

class CleanCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'schedulelogger:clean {days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old records from the schedule log.';

    public function handle()
    {
        $maxAgeInDays = $this->argument('days');

        $this->comment("Cleaning schedule log, but keeping the records of the last {$maxAgeInDays}...");

        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');

        $amountDeleted = Schedulelog::where('created_at', '<', $cutOffDate)->delete();

        $this->info("Deleted {$amountDeleted} record(s) from the schedule log.");

        $this->comment('All done!');
    }
}
