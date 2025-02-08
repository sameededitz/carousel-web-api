<?php

namespace App\Http\Controllers;

use App\Models\BackgroundOverlay;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BackgroundOverlayController extends Controller
{
    public function view(Carousel $carousel)
    {
        Gate::authorize('view', $carousel);

        $backgroundOverlay = $carousel->backgroundOverlay;

        return response()->json([
            'status' => true,
            'backgroundOverlay' => $backgroundOverlay
        ], $backgroundOverlay ? 200 : 404);
    }

    /**
     * Create or update the background overlay for a carousel.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id'           => 'required|exists:carousels,id',
            'background_id'         => 'required|string',
            'overlay_color'         => 'required|string',
            'overlay_opacity'       => 'nullable|numeric',
            'is_overlay_fade_corner' => 'required|boolean',
            'corner_element_id'     => 'required|string',
            'corner_element_opacity' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Find the carousel that belongs to the authenticated user
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if (!$carousel) {
            return response()->json([
                'status'  => false,
                'message' => 'Carousel not found or you do not own it.'
            ], 403);
        }

        Gate::authorize('view', $carousel);

        // Retrieve the associated background overlay if it exists
        $backgroundOverlay = $carousel->backgroundOverlay;

        if ($backgroundOverlay) {
            Gate::authorize('update', $backgroundOverlay);
            $backgroundOverlay->update($request->only([
                'background_id',
                'overlay_color',
                'overlay_opacity',
                'is_overlay_fade_corner',
                'corner_element_id',
                'corner_element_opacity'
            ]));
            $message = 'Background overlay updated successfully';
        } else {
            Gate::authorize('create', [BackgroundOverlay::class, $carousel]);
            $backgroundOverlay = $carousel->backgroundOverlay()->create($request->only([
                'background_id',
                'overlay_color',
                'overlay_opacity',
                'is_overlay_fade_corner',
                'corner_element_id',
                'corner_element_opacity'
            ]));
            $message = 'Background overlay created successfully';
        }

        return response()->json([
            'status'            => true,
            'message'           => $message,
            'backgroundOverlay' => $backgroundOverlay
        ], $backgroundOverlay->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Delete the background overlay for a given carousel.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Find the carousel owned by the user
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if (!$carousel) {
            return response()->json([
                'status'  => false,
                'message' => 'Carousel not found or you do not own it.'
            ], 403);
        }

        Gate::authorize('view', $carousel);

        // Retrieve the associated background overlay
        $backgroundOverlay = $carousel->backgroundOverlay;

        if (!$backgroundOverlay) {
            return response()->json([
                'status'  => false,
                'message' => 'No background overlay found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $backgroundOverlay);
        $backgroundOverlay->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Background overlay deleted successfully',
        ], 200);
    }
}
