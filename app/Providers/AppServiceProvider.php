<?php

namespace App\Providers;

use App\Listeners\UpdateLastLogin;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
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
        Event::listen(
            UpdateLastLogin::class
        );

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(optional($request->user())->id ?: $request->ip());
        });
        RateLimiter::for('api', function (Request $request) {
            $maxAttempts = 6;
            $key = optional($request->user())->id ?: $request->ip();

            $remainingAttempts = RateLimiter::remaining($key, $maxAttempts);
            $remainingSeconds = RateLimiter::availableIn($key, $maxAttempts);

            return Limit::perMinute($maxAttempts)->by($key)->response(function (Request $request, array $headers) use ($remainingAttempts, $remainingSeconds) {
                return response()->json([
                    'message' => "Too many requests. Remaining attempts: $remainingAttempts. Try again in $remainingSeconds seconds.",
                ], 429, $headers);
            });
        });
    }
}
