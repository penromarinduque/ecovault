<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Jobs\ArchiveOldFilesJob;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

function schedule(Schedule $schedule)
{
    // Runs every day at midnight
    $schedule->job(new ArchiveOldFilesJob())->daily();
}
