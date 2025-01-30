<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function view(Carousel $carousel)
    {
        Gate::authorize('view', $carousel);

        return response()->json([
            'status' => true,
            'color' => $carousel->color
        ], $carousel->color ? 200 : 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
            'is_use_custom_colors' => 'required|boolean',
            'is_alternate_slide_colors' => 'required|boolean',
            'background_color' => 'required|string',
            'text_color' => 'required|string',
            'accent_color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Find carousel
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if (!$carousel) {
            return response()->json([
                'status' => false,
                'message' => 'Carousel not found or you do not own it.'
            ], 403);
        }

        Gate::authorize('view', $carousel);

        // Check if color settings already exist
        $color = $carousel->color;

        if ($color) {
            Gate::authorize('update', $color);
            $color->update($request->only([
                'is_use_custom_colors',
                'is_alternate_slide_colors',
                'background_color',
                'text_color',
                'accent_color'
            ]));
            $message = 'Color settings updated successfully';
        } else {
            Gate::authorize('create', [Color::class, $carousel]);
            $color = $carousel->color()->create($request->only([
                'is_use_custom_colors',
                'is_alternate_slide_colors',
                'background_color',
                'text_color',
                'accent_color'
            ]));
            $message = 'Color settings created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'color' => $color
        ], $color->wasRecentlyCreated ? 201 : 200);
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

        // Find the carousel and check if it belongs to the authenticated user
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if (!$carousel) {
            return response()->json([
                'status' => false,
                'message' => 'Carousel not found or you do not own it.'
            ], 403);
        }

        Gate::authorize('view', $carousel); // Ensuring the user can modify this carousel

        // Retrieve the associated ContentText
        $color = $carousel->colors;

        if (!$color) {
            return response()->json([
                'status' => false,
                'message' => 'No colors found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $color);
        $color->delete();

        return response()->json([
            'status' => true,
            'message' => 'ContentText deleted successfully',
        ], 200);
    }
}
