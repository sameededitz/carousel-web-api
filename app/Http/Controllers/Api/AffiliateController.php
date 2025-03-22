<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Earning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\AffiliateApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AffiliateController extends Controller
{
    public function apply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliate_applications,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        // Ensure the email is not already registered as a regular user.
        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'This email is already registered as a regular user. Please use a different email for the affiliate program.',
            ], 400);
        }

        // Create the affiliate application using the hashed password.
        $application = AffiliateApplication::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Affiliate application submitted successfully. Please wait for approval.',
            'application' => $application,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        // Find the user with the given email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => __('auth.failed'),
            ], 401);
        }

        // Ensure the user is an affiliate
        if ($user->role !== 'affiliate') {
            return response()->json([
                'status'  => false,
                'message' => 'Only affiliate users can log in here.',
            ], 403);
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => __('auth.password'),
            ], 401);
        }

        // Create authentication token
        $token = $user->createToken('affiliate_token')->plainTextToken;

        return response()->json([
            'status'       => true,
            'message'      => 'Affiliate user logged in successfully!',
            'user'         => new UserResource($user),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 200);
    }

    public function invitedUsers()
    {
        $user = Auth::user();

        $invitedUsers = $user->referredUsers()
            ->with('earnings')
            ->get()
            ->map(function ($invitedUser) use ($user) {
                // Calculate total earnings from this referred user
                $totalEarnings = Earning::where('user_id', $user->id)
                    ->where('referred_user_id', $invitedUser->id)
                    ->sum('amount');

                return [
                    'id' => $invitedUser->id,
                    'name' => $invitedUser->name,
                    'email' => $invitedUser->email,
                    'referral_code' => $invitedUser->referral_code,
                    'total_earned' => $totalEarnings,
                ];
            });

        return response()->json([
            'status' => true,
            'invited_users' => $invitedUsers
        ]);
    }

    public function stats()
    {
        $user = Auth::user();
        $totalUsers = $user->referredUsers()->count();
        $totalEarnings = $user->earnings()->sum('amount');

        return response()->json([
            'status' => true,
            'total_users' => $totalUsers,
            'total_earnings' => $totalEarnings,
            'referral_code' => $user->referral_code
        ]);
    }

    public function earningHistory()
    {
        $user = Auth::user();
        $earnings = $user->earnings()
            ->with('referredUser:id,name,email')
            ->latest()
            ->get()
            ->map(function ($earning) {
                return [
                    'id' => $earning->id,
                    'amount' => $earning->amount,
                    'purchase_id' => $earning->purchase_id,
                    'date' => $earning->created_at->format('Y-m-d H:i:s'),
                    'referred_user' => [
                        'id' => $earning->referredUser->id ?? null,
                        'name' => $earning->referredUser->name ?? 'Unknown',
                        'email' => $earning->referredUser->email ?? 'N/A',
                    ]
                ];
            });

        return response()->json([
            'status' => true,
            'earnings' => $earnings
        ]);
    }
}
