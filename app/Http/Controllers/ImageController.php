<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:30720', // max:30MB
            'old_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        /** @var \Illuminate\Filesystem\FilesystemManager $disk */
        $disk = Storage::disk('images');

        if ($request->has('old_url')) {
            $oldUrl = $request->input('old_url');
            $oldPath = str_replace($disk->url(''), '', $oldUrl);

            if (Storage::disk('images')->exists($oldPath)) {
                Storage::disk('images')->delete($oldPath);
            }
        }

        $file = $request->file('image');

        // Create a unique filename using current time and uniqid.
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file in the root of the "images" disk.
        $path = $file->storeAs('', $filename, 'images');

        // Retrieve the full URL using the disk's URL configuration.
        $url = $disk->url($filename);

        return response()->json([
            'status' => true,
            'url'    => $url,
        ], 200);
    }
}
