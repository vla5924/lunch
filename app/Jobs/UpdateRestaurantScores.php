<?php

namespace App\Jobs;

use App\Models\Restaurant;
use App\Models\RestaurantScore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateRestaurantScores implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $values = ['outdated' => false, 'updated_at' => now()];
            $values['score'] = $restaurant->evaluations()->avg('total') ?? 0.0;
            $values['bans'] = $restaurant->bans()->count() ?? 0;
            RestaurantScore::updateOrInsert(['restaurant_id' => $restaurant->id], $values);
        }
    }
}
