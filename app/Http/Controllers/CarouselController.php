<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CarouselController extends Controller
{
    public function carousels()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'carousels' => $user->carousels
        ], 200);
    }

    public function view(Carousel $carousel)
    {
        Gate::authorize('view', $carousel);
        return response()->json([
            'status' => true,
            'carousel' => $carousel
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'nullable|exists:carousels,id',
            'title' => 'required|string',
            'data' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:30720',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Check if the user is non-premium (does not have an active plan)
        $isPremium = $user->activePlan()->exists();
        $carouselCount = $user->carousels()->count();

        if (!$isPremium && $carouselCount >= 10) {
            return response()->json([
                'status' => false,
                'message' => 'You have reached the maximum limit of 10 carousels. Upgrade to a premium plan to create more.'
            ], 403);
        }

        // Check if a carousel ID is provided for updating
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if ($carousel) {
            Gate::authorize('update', $carousel);

            // Update existing carousel
            $carousel->update([
                'title' => $request->input('title'),
                'options' => $request->input('options'),
            ]);

            $message = 'Carousel updated successfully';
        } else {
            // Create a new carousel
            $carousel = $user->carousels()->create([
                'title' => $request->input('title'),
                'options' => $request->input('options'),
            ]);

            $message = 'Carousel created successfully';
        }

        if ($request->has('image')) {
            $carousel->clearMediaCollection('image');
            $carousel->addMedia($request->file('image')->getRealPath())
                ->usingFileName($request->file('image')->getClientOriginalName())
                ->toMediaCollection('image');
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'carousel' => $carousel
        ], $carousel->wasRecentlyCreated ? 201 : 200);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Check if a carousel ID is provided for deletion
        $carousel = $user->carousels()->find($request->input('carousel_id'));
        if ($carousel) {
            Gate::authorize('delete', $carousel);
            $carousel->delete();
            return response()->json([
                'status' => true,
                'message' => 'Carousel deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Carousel not found',
            ], 404);
        }
    }
}
