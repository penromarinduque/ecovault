<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ArchiveOldFiles;
use Illuminate\Console\Scheduling\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



// Schedule the command
Artisan::command('schedule', function (Schedule $schedule) {
    $schedule->command('files:archive')->daily();
});

app()->booted(function () {
    app(Schedule::class)->command('files:archive')->everyTenMinutes();
});