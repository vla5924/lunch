<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $prevVisit = Visit::where('datetime', '<', now())->orderBy('datetime', 'desc')->first();
        $nextVisit = Visit::where('datetime', '>=', now())->orderBy('datetime', 'asc')->first();

        $today = now();
        $currentEvent = Event::query()
            ->where('day', $today->day)
            ->where('month', $today->month)
            ->where(function (Builder $query) use ($today) {
                $query->where('annual', true)->orWhere('year', $today->year);
            })
            ->first();
        $nextEvent = Event::query()
            ->where(function (Builder $query) use ($today) {
                // For annual events (recurring every year)
                $query->where('annual', true)
                    ->where(function (Builder $query) use ($today) {
                        // Events in current month but after today's day
                        $query->where('month', $today->month)
                            ->where('day', '>', $today->day);
                        // OR events in months after current month
                        $query->orWhere('month', '>', $today->month);
                    });
            })
            ->orWhere(function (Builder $query) use ($today) {
                // For non-annual events (specific year matters)
                $query->where('annual', false)
                    ->where(function (Builder $query) use ($today) {
                        // Events in current year
                        $query->where('year', $today->year)
                            ->where(function (Builder $query) use ($today) {
                                // In current month but after today
                                $query->where('month', $today->month)
                                    ->where('day', '>', $today->day);
                                // OR in future months of current year
                                $query->orWhere('month', '>', $today->month);
                            });
                        // OR events in future years
                        $query->orWhere('year', '>', $today->year);
                    });
            })
            ->orderByRaw("
                CASE
                    WHEN annual = 1 THEN month * 100 + day
                    ELSE year * 10000 + month * 100 + day
                END
            ")
            ->first();

        return view('pages.home.index', [
            'prev_visit' => $prevVisit,
            'next_visit' => $nextVisit,
            'current_event' => $currentEvent,
            'next_event' => $nextEvent,
        ]);
    }
}
