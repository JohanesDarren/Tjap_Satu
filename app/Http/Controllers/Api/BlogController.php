<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get all published blogs
     */
    public function index(Request $request)
    {
        $query = Blog::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        // Pagination
        $perPage = $request->get('per_page', 10);
        $blogs = $query->paginate($perPage);

        $data = $blogs->map(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'excerpt' => $blog->excerpt,
                'cover' => $blog->cover_path ? url('storage/' . $blog->cover_path) : null,
                'published_at' => $blog->published_at?->toISOString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ], 200);
    }

    /**
     * Get single blog details
     */
    public function show($id)
    {
        $blog = Blog::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->find($id);

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'cover' => $blog->cover_path ? url('storage/' . $blog->cover_path) : null,
                'published_at' => $blog->published_at?->toISOString(),
                'created_at' => $blog->created_at?->toISOString(),
                'updated_at' => $blog->updated_at?->toISOString(),
            ]
        ], 200);
    }
}
