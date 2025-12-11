<?php

namespace App\Providers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use App\Policies\EventPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('reviews', function (Request $request) {
            return Limit::perHour(3)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Gate::define('update-event', function (User $user, Event $event) {
        //     return $user->id === $event->user_id;
        // });

        Gate::policy(Event::class, EventPolicy::class);

        Gate::define('list-attendees', function (User $user, Event $event) {
            return $user->id === $event->user_id;
        });

        Gate::define('show-attendee', function (User $user, Event $event, Attendee $attendee) {
            return $user->id === $event->user_id && $attendee->event_id === $event->id;
        });

        Gate::define('delete-attendee', function (User $user, Event $event, Attendee $attendee) {
            return $user->id === $event->user_id && $attendee->event_id === $event->id;
        });
    }
}
