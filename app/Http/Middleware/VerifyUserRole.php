<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $roles)) {
            return $request->wantsJson()
                ? response()->json([
                    'message' => 'Unauthorized. You do not have the required role.'
                ], Response::HTTP_UNAUTHORIZED)
                : redirect()->route('login')->with([
                    'status' => 'error',
                    'message' => 'You do not have access to this section.'
                ]);
        }

        return $next($request);
    }
}
