<?php

use App\Jobs\UpdateRestaurantScores;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('run:update-restaurant-scores', function () {
    $this->info('Run UpdateRestaurantScores...');
    $job = new UpdateRestaurantScores;
    $job->handle();
    $this->info('Task finished.');
})->purpose('Update restaurant scores (run job)');

// Run the scheduler with Cron:
// * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

Schedule::job(new UpdateRestaurantScores)->hourly();

// Run the queue worker
Schedule::command('queue:work --stop-when-empty --timeout=59')->everyMinute()->withoutOverlapping();
