<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

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
}
