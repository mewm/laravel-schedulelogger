# Log execution time of scheduled tasks in Laravel


This package automatically logs the execution times of scheduled tasks in Laravel. Simply replace the default Schedule class by the LogSchedule class and times will be saved to the database by default.

## Installation & Usage

Install the package using composer:

`composer require mewm/laravel-schedulelogger`

Add the Service Provider and Facade to config/app.php. (For Laravel 5.5 and up Auto-Discovery is enabled)

```php
'providers' => [
    ...
    PendoNL\LaravelScheduleLogger\LaravelScheduleLoggerServiceProvider::class,
    ...
]
```

and

```php
'aliases' => [
    ...
    'LogSchedule' => PendoNL\LaravelScheduleLogger\Facade::class,
    ...
]
```

Next step is to publish and run the migrations:

```console
php artisan vendor:publish --provider="PendoNL\LaravelScheduleLogger\LaravelScheduleLoggerServiceProvider"
php artisan migrate
```

Then we must replace the default Schedule instance that is used by events, for this we need to edit app/Console/Kernel.php. At the bottom of the file add this method:

```php
/**
 * Define the application's command schedule.
 *
 * @return void
 */
protected function defineConsoleSchedule()
{
    if (App::environment('local', 'staging')) {
        $this->app->instance(
            'Illuminate\Console\Scheduling\Schedule', $schedule = new \PendoNL\LaravelScheduleLogger\Console\Scheduling\LogSchedule
        );
    } else {
        $this->app->instance(
            'Illuminate\Console\Scheduling\Schedule', $schedule = new Schedule
        );
    }
    
    $this->schedule($schedule);
}
```

Also make sure you import the App Facade at top of app/Console/Kernel.php:

```php
use App;
```

After this is done, test the setup by running `php artisan schedule:run`, if everything worked out you see no errors and in your database the table `schedulelogs` is filled with X records.

You can clean the log with this command `php artisan schedulelogger:clean`. Or by adding this schedule job:
```php
$schedule->command('schedulelogger:clean');
```
You can specify the amount of logs to keep. The argument `days` is optional and defaults to 30 days, for example, to only keep the records of the last week, the command would be:

`php artisan schedulelogger:clean 7`

## Showing execution times

To display the information on screen you can import the model in your controller:

```php
use PendoNL\LaravelScheduleLogger\Schedulelog;
```

After this, it's just a mather of getting the records. The LogSchedule Facade has a simple method to return the execution time in milliseconds. Below is an example.

```php
foreach(Schedulelog::take(10)->get() as $log) {
    $ms = LogSchedule::getExecutiontime($log);
    echo "Execution of command [$log->command_name] took [$ms] milliseconds";
}
```

## Credits
- [Joshua de Gier](mailto:joshua@pendo.nl)
- [Stijn Vanouplines](mailto:stijn@solitweb.be)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
