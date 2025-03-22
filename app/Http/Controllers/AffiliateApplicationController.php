<?php

namespace App\Http\Controllers;

use App\Models\AffiliateApplication;
use App\Models\User;

class AffiliateApplicationController extends Controller
{
    public function index()
    {
        return view('admin.all-applications');
    }

    public function applications()
    {
        $applications = AffiliateApplication::latest()->get();
        return response()->json($applications, 200);
    }

    public function approve($id)
    {
        $application = AffiliateApplication::findOrFail($id);

        if ($application->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'This application has already been processed.',
            ]);
        }

        // Generate a unique referral code.
        $referralCode = strtoupper('AFF-' . time() . '-' . uniqid());

        // Check if a user already exists with this email.
        $user = User::where('email', $application->email)->first();

        if ($user) {
            // Update the existing user's credentials and set google_id and avatar to null.
            $user->update([
                'name'        => $application->name,
                'password'    => $application->password,
                'role'        => 'affiliate', // or update as needed
                'referral_code' => $referralCode,
                'email_verified_at' => now(),
                'google_id'   => null,
                'avatar'      => null,
            ]);
        } else {
            // Create a new user with the application details.
            $user = User::create([
                'name'        => $application->name,
                'email'       => $application->email,
                'password'    => $application->password,
                'email_verified_at' => now(),
                'role'        => 'affiliate', // or update as needed
                'referral_code' => $referralCode,
            ]);
        }

        // Update the affiliate application record.
        $application->update([
            'status'        => 'approved',
            'approved_at'   => now(),
            'referral_code' => $referralCode,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Affiliate application approved successfully.',
        ], 200);
    }

    public function cancel($id)
    {
        $application = AffiliateApplication::findOrFail($id);

        if ($application->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'Only pending applications can be cancelled.',
            ]);
        }

        $application->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Affiliate application cancelled successfully.',
        ], 200);
    }

    public function delete($id)
    {
        $application = AffiliateApplication::findOrFail($id);

        $application->delete();

        return response()->json([
            'status' => true,
            'message' => 'Affiliate application deleted successfully.',
        ], 200);
    }
}
