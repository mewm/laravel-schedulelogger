# Log execution time of scheduled tasks in Laravel

[![Latest version on Packagist](https://img.shields.io/packagist/v/pendonl/schedulelogger.svg?style=flat-square)](https://packagist.org/packages/pendonl/laravel-schedulelogger)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Travis branch](https://img.shields.io/travis/PendoNL/schedulelogger/master.svg)](https://travis-ci.org/PendoNL/laravel-schedulelogger)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/PendoNL/schedulelogger.svg)](https://scrutinizer-ci.com/g/PendoNL/laravel-schedulelogger/)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/0bcf56eb-37d1-4525-a4ef-2375d03563aa.svg)](https://insight.sensiolabs.com/projects/e660c560-9d50-43e3-9be1-e556ba78f189)
[![Style Ci](https://styleci.io/repos/73438968/shield)](https://styleci.io/repos/73438968/)
[![Github All Releases](https://img.shields.io/github/downloads/pendo/pro6pp-php-wrapper/total.svg)](https://github.com/pendonl/laravel-schedulelogger)

This package automatically logs the execution times of scheduled tasks in Laravel. Simply replace the default Schedule class by the LogSchedule class and times will be saved to the database by default.

## Installation & Usage

Install the package using composer:

`composer require pendonl/laravel-logschedule`

Add the Service Provider and Facade to config/app.php:

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
php artisan vendor:publish
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

## Showing execution times

To display the information on screen you can import the model in your controller:

```php
use \PendoNL\
```

## Security

If you discover any security related issues, please email joshua@pendo.nl instead of using the issue tracker.

## Credits

Thanks to Pro6PP for their efforts to create, maintain and update a postal database for a fair price.

## About Pendo
Pendo is a webdevelopment agency based in Maastricht, Netherlands. If you'd like, you can [visit our website](https://pendo.nl).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
