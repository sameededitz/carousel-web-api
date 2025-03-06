<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PlanController extends Controller
{
    public function Index()
    {
        $plans = Plan::all();
        return view('admin.all-plans', compact('plans'));
    }

    public function deletePlan(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('all-plans')->with([
            'status' => 'success',
            'message' => 'Plan Deleted Successfully.',
        ]);
    }

    public function plans()
    {
        $plans = Plan::all()->map(function($plan) {
            $plan->price = (float) $plan->price;
            return $plan;
        });
        return response()->json([
            'status' => true,
            'plans' => $plans,
        ], 200);
    }
}
