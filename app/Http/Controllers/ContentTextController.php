<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\ContentText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ContentTextController extends Controller
{
    public function view(Carousel $carousel)
    {
        Gate::authorize('view', $carousel);

        return response()->json([
            'status' => true,
            'contentText' => $carousel->contentText ?? null
        ], $carousel->contentText ? 200 : 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id' => 'required|exists:carousels,id',
            'is_custom_fonts_enabled' => 'required|boolean',
            'primary_font_name' => 'required|string',
            'primary_font_href' => 'required|string',
            'secondary_font_name' => 'required|string',
            'secondary_font_href' => 'required|string',
            'font_size' => 'required|numeric',
            'font_text_alignment' => 'required|in:center,left,right',
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

        // Check if content text already exists
        $contentText = $carousel->contentText;

        if ($contentText) {
            Gate::authorize('update', $contentText);
            $contentText->update($request->only([
                'is_custom_fonts_enabled',
                'primary_font_name',
                'primary_font_href',
                'secondary_font_name',
                'secondary_font_href',
                'font_size',
                'font_text_alignment',
            ]));
            $message = 'ContentText updated successfully';
        } else {
            Gate::authorize('create', [ContentText::class, $carousel]);
            $contentText = $carousel->contentText()->create($request->only([
                'is_custom_fonts_enabled',
                'primary_font_name',
                'primary_font_href',
                'secondary_font_name',
                'secondary_font_href',
                'font_size',
                'font_text_alignment',
            ]));
            $message = 'ContentText created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'contentText' => $contentText
        ], $contentText->wasRecentlyCreated ? 201 : 200);
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
        $contentText = $carousel->contentText;

        if (!$contentText) {
            return response()->json([
                'status' => false,
                'message' => 'No content text found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $contentText);
        $contentText->delete();

        return response()->json([
            'status' => true,
            'message' => 'ContentText deleted successfully',
        ], 200);
    }
}
