<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function applyReferral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required|string|exists:users,referral_code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        $user = Auth::user();
        
        if ($user->referred_by) {
            return response()->json([
                'status' => false,
                'message' => 'You have already applied a referral code.',
            ], 400);
        }

        $referredUser = User::where('referral_code', $request->referral_code)->first();

        if (!$referredUser) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid referral code.',
            ], 400);
        }

        if ($referredUser->id === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot use your own referral code.',
            ], 400);
        }

        $user->update([
            'referred_by' => $referredUser->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Referral code applied successfully.',
        ], 200);
    }
}
