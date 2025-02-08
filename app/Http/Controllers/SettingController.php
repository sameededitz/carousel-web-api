<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * View the settings for a given carousel.
     */
    public function view(Carousel $carousel)
    {
        // Authorize viewing of the carousel (ownership check)
        Gate::authorize('view', $carousel);

        $setting = $carousel->setting; // Assumes a one-to-one relation: Carousel hasOne Setting

        return response()->json([
            'status'  => true,
            'setting' => $setting
        ], $setting ? 200 : 404);
    }

    /**
     * Create or update the settings for a carousel.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id'         => 'required|exists:carousels,id',
            'is_show_water_mark'  => 'required|boolean',
            'is_hide_intro_slide' => 'required|boolean',
            'is_hide_outro_slide' => 'required|boolean',
            'is_hide_counter'     => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Retrieve the carousel that belongs to the user
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if (!$carousel) {
            return response()->json([
                'status'  => false,
                'message' => 'Carousel not found or you do not own it.'
            ], 403);
        }

        // Authorize viewing to ensure the user owns the carousel
        Gate::authorize('view', $carousel);

        // Retrieve the associated settings, if any
        $setting = $carousel->setting;

        if ($setting) {
            // If settings exist, authorize updating and then update them
            Gate::authorize('update', $setting);
            $setting->update($request->only([
                'is_show_water_mark',
                'is_hide_intro_slide',
                'is_hide_outro_slide',
                'is_hide_counter'
            ]));
            $message = 'Settings updated successfully';
        } else {
            // Otherwise, authorize creation and create new settings
            Gate::authorize('create', [Setting::class, $carousel]);
            $setting = $carousel->setting()->create($request->only([
                'is_show_water_mark',
                'is_hide_intro_slide',
                'is_hide_outro_slide',
                'is_hide_counter'
            ]));
            $message = 'Settings created successfully';
        }

        return response()->json([
            'status'  => true,
            'message' => $message,
            'setting' => $setting
        ], $setting->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Delete the settings for a given carousel.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Find the carousel owned by the user
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        // Authorize viewing of the carousel
        Gate::authorize('view', $carousel);

        // Retrieve the associated settings
        $setting = $carousel->setting;

        if (!$setting) {
            return response()->json([
                'status'  => false,
                'message' => 'No settings found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $setting);
        $setting->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Settings deleted successfully',
        ], 200);
    }
}
