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
            'locale' => 'required|string',
            'current_index' => 'required|integer',
            'zoom_value' => 'required|numeric',
            'slide_ratio_id' => 'required|integer',
            'slide_ratio_width' => 'required|numeric',
            'slide_ratio_height' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Check if a carousel ID is provided for updating
        $carousel = $user->carousels()->find($request->input('carousel_id'));

        if ($carousel) {
            Gate::authorize('update', $carousel);

            // Update existing carousel
            $carousel->update([
                'locale' => $request->input('locale'),
                'current_index' => $request->input('current_index'),
                'zoom_value' => $request->input('zoom_value'),
                'slide_ratio_id' => $request->input('slide_ratio_id'),
                'slide_ratio_width' => $request->input('slide_ratio_width'),
                'slide_ratio_height' => $request->input('slide_ratio_height'),
            ]);

            $message = 'Carousel updated successfully';
        } else {
            // Create a new carousel
            $carousel = $user->carousels()->create([
                'locale' => $request->input('locale'),
                'current_index' => $request->input('current_index'),
                'zoom_value' => $request->input('zoom_value'),
                'slide_ratio_id' => $request->input('slide_ratio_id'),
                'slide_ratio_width' => $request->input('slide_ratio_width'),
                'slide_ratio_height' => $request->input('slide_ratio_height'),
            ]);

            $message = 'Carousel created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'carousel' => $carousel
        ], 200);
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
