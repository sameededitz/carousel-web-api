<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $route = $request->path(); // Get route path
        $userAgent = $request->header('User-Agent');

        // Log request info
        Log::info("Request received", [
            'ip' => $ip,
            'route' => $route,
            'user_agent' => $userAgent
        ]);

        // Track request count per route
        $cacheKey = "route_hits:{$route}";
        Cache::increment($cacheKey);

        return $next($request);
    }
}
