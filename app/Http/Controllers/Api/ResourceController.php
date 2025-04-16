<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Faq;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    public function posts()
    {
        // Fetch posts from the database
        $posts = Post::with(['category', 'user'])
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(10);

        // Return the posts as a JSON response
        return PostResource::collection($posts);
    }

    public function post($slug)
    {
        // Fetch the post by slug
        $post = Post::with(['category', 'user', 'tags'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Return the post as a JSON response
        return new PostResource($post);
    }

    public function faqStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        Faq::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Your message has been sent successfully.'
        ], 200);
    }
}
