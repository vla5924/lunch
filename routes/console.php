<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run the scheduler with Cron:
// * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

// Run the queue worker
Schedule::command('queue:work --stop-when-empty --timeout=59')->everyMinute()->withoutOverlapping();
