<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function view(Brand $brand)
    {
        Gate::authorize('view', $brand);

        return response()->json([
            'status' => true,
            'brand' => $brand
        ], $brand ? 200 : 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
            'is_show_in_intro_slide' => 'required|boolean',
            'is_show_in_outro_slide' => 'required|boolean',
            'is_show_in_regular_slide' => 'required|boolean',
            'name_text' => 'required|string',
            'name_is_enabled' => 'required|boolean',
            'handle_text' => 'required|string',
            'handle_is_enabled' => 'required|boolean',
            'profile_image_src' => 'required|image|mimes:jpeg,png,jpg,gif|max:20420', // 20MB
            'profile_image_is_enabled' => 'required|boolean',
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

        // Check if brand settings already exist
        /** @var \App\Models\Brand $brand **/
        $brand = $carousel->brand;

        if ($brand) {
            Gate::authorize('update', $brand);
            $brand->update($request->only([
                'is_show_in_intro_slide',
                'is_show_in_outro_slide',
                'is_show_in_regular_slide',
                'name_text',
                'name_is_enabled',
                'handle_text',
                'handle_is_enabled',
                'profile_image_is_enabled',
            ]));

            if ($request->has('profile_image_src')) {
                $brand->clearMediaCollection('profile_image_src');
                $brand->addMedia($request->file('profile_image_src')->getRealPath())
                    ->usingFileName($request->file('profile_image_src')->getClientOriginalName())
                    ->toMediaCollection('profile_image_src');
            }

            $message = 'Brand settings updated successfully';
        } else {
            Gate::authorize('create', [Brand::class, $carousel]);
            /** @var \App\Models\Brand $brand **/
            $brand = $carousel->brand()->create($request->only([
                'is_show_in_intro_slide',
                'is_show_in_outro_slide',
                'is_show_in_regular_slide',
                'name_text',
                'name_is_enabled',
                'handle_text',
                'handle_is_enabled',
                'profile_image_is_enabled',
            ]));

            if ($request->has('profile_image_src')) {
                $brand->addMedia($request->file('profile_image_src')->getRealPath())
                    ->usingFileName($request->file('profile_image_src')->getClientOriginalName())
                    ->toMediaCollection('profile_image_src');
            }

            $message = 'Brand settings created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'brand' => $brand
        ], $brand->wasRecentlyCreated ? 201 : 200);
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

        // Retrieve the associated Brand
        /** @var \App\Models\Brand $brand **/
        $brand = $carousel->brand;

        if (!$brand) {
            return response()->json([
                'status' => false,
                'message' => 'No brand found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $brand);
        $brand->clearMediaCollection('profile_image_src');
        $brand->delete();

        return response()->json([
            'status' => true,
            'message' => 'Brand deleted successfully',
        ], 200);
    }
}
