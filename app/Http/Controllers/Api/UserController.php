<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'user' => new UserResource($user->load('activePlan.plan'))
        ], 200);
    }

    public function incrementAiCreations()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Increment the count by 1
        $user->increment('ai_creations');

        return response()->json([
            'status' => true,
            'message' => 'AI Creations incremented successfully',
            'ai_creations' => $user->ai_creations,
            'user' => new UserResource($user->load('activePlan.plan'))
        ], 200);
    }
}
