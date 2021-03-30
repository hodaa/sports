<?php

namespace App\Providers;

use App\Models\Match;
use App\Models\Season;
use App\Models\Week;
use App\Observers\MatchObserver;
use App\Observers\SeasonObserver;
use App\Observers\WeekObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Season::observe(SeasonObserver::class);
        Week::observe(WeekObserver::class);
        Match::observe(MatchObserver::class);
    }
}
