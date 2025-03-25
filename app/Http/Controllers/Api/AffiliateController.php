<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
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

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Affiliate user logged out successfully!',
        ], 200);
    }

    public function invitedUsers()
    {
        $user = Auth::user();

        $invitedUsers = $user->referredUsers()
            ->select('id', 'name', 'email', 'referred_by')
            ->withSum('earningsFromReferrals', 'amount')
            ->with(['referrer:id,referral_code'])
            ->get()
            ->map(function ($invitedUser) {
                return [
                    'id' => $invitedUser->id,
                    'name' => $invitedUser->name,
                    'email' => $invitedUser->email,
                    'referral_code' => $invitedUser->referrer->referral_code ?? 'N/A',
                    'total_earned' => $invitedUser->earnings_from_referrals_sum_amount ?? "0.00",
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

        if ($totalEarnings === null) {
            $totalEarnings = "0.00";
        }

        if ($totalUsers === null) {
            $totalUsers = "0";
        }

        $totalwithdrawals = $user->withdrawals()->sum('amount');

        return response()->json([
            'status' => true,
            'total_users' => $totalUsers,
            'total_earnings' => $totalEarnings,
            'total_withdrawals' => $totalwithdrawals,
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
                        'id' => optional($earning->referredUser)->id,
                        'name' => optional($earning->referredUser)->name ?? 'Unknown',
                        'email' => optional($earning->referredUser)->email ?? 'N/A',
                    ]
                ];
            });

        return response()->json([
            'status' => true,
            'earnings' => $earnings
        ]);
    }
}
