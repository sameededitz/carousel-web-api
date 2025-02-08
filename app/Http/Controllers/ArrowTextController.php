<?php

namespace App\Http\Controllers;

use App\Models\ArrowText;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ArrowTextController extends Controller
{
     /**
     * View the arrow text for a given carousel.
     */
    public function view(Carousel $carousel)
    {
        Gate::authorize('view', $carousel);
        
        // Retrieve the associated ArrowText (assuming one-to-one relation)
        $arrowText = $carousel->arrowText;

        return response()->json([
            'status'    => true,
            'arrowText' => $arrowText
        ], $arrowText ? 200 : 404);
    }

    /**
     * Create or update the arrow text for a carousel.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carousel_id'                   => 'required|exists:carousels,id',
            'arrow_id'                      => 'required|string',
            'is_only_arrow'                 => 'required|boolean',
            'intro_slide_arrow_text'        => 'required|string',
            'intro_slide_arrow_is_enabled'  => 'required|boolean',
            'regular_slide_arrow_text'      => 'required|string',
            'regular_slide_arrow_is_enabled'=> 'required|boolean',
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

        // Retrieve the associated ArrowText if it exists
        $arrowText = $carousel->arrowText;

        if ($arrowText) {
            Gate::authorize('update', $arrowText);
            $arrowText->update($request->only([
                'arrow_id',
                'is_only_arrow',
                'intro_slide_arrow_text',
                'intro_slide_arrow_is_enabled',
                'regular_slide_arrow_text',
                'regular_slide_arrow_is_enabled'
            ]));
            $message = 'Arrow text updated successfully';
        } else {
            Gate::authorize('create', [ArrowText::class, $carousel]);
            $arrowText = $carousel->arrowText()->create($request->only([
                'arrow_id',
                'is_only_arrow',
                'intro_slide_arrow_text',
                'intro_slide_arrow_is_enabled',
                'regular_slide_arrow_text',
                'regular_slide_arrow_is_enabled'
            ]));
            $message = 'Arrow text created successfully';
        }

        return response()->json([
            'status'    => true,
            'message'   => $message,
            'arrowText' => $arrowText
        ], $arrowText->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Delete the arrow text for a given carousel.
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
        Gate::authorize('view', $carousel);

        // Retrieve the associated ArrowText
        $arrowText = $carousel->arrowText;

        if (!$arrowText) {
            return response()->json([
                'status'  => false,
                'message' => 'No arrow text found for this carousel.'
            ], 404);
        }

        Gate::authorize('delete', $arrowText);
        $arrowText->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Arrow text deleted successfully',
        ], 200);
    }
}
