<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function savePaypalDetails(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'paypal_email' => 'required|email',
            'paypal_username' => 'required|string|max:255',
            'paypal_phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $user->paymentDetails()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'paypal_email' => $request->paypal_email,
                'paypal_username' => $request->paypal_username,
                'paypal_phone' => $request->paypal_phone,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'PayPal details saved successfully!'
        ], 200);
    }

    public function requestWithdrawal(Request $request)
    {
        $user = Auth::user();
        $paymentDetails = $user->paymentDetails;

        if (!$paymentDetails) {
            return response()->json(['status' => false, 'message' => 'Please set your PayPal details first.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10|max:' . $user->balance,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        // Create withdrawal request
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'paypal_email' => $paymentDetails->paypal_email,
            'paypal_username' => $paymentDetails->paypal_username,
            'paypal_phone' => $paymentDetails->paypal_phone,
            'status' => 'pending',
        ]);

        // Deduct from balance
        $user->decrement('balance', $request->amount);

        return response()->json([
            'status' => true,
            'message' => 'Withdrawal request submitted successfully!',
            'withdrawal' => $withdrawal,
        ], 200);
    }

    public function withdrawalHistory()
    {
        $user = Auth::user();
        $withdrawals = $user->withdrawals()->latest()->get();

        return response()->json([
            'status' => true,
            'withdrawals' => $withdrawals
        ]);
    }
}
