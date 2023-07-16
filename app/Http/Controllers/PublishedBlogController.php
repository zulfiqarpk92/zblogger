<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class PublishedBlogController extends Controller
{
    public function index(Request $request)
    {
        $q =  '%' . $request->input('q') . '%';
        $blogs = Blog::withCount('likes')->where(function ($query) use ($q) {
            $query->where('title', 'LIKE', $q)
                ->orWhere('body', 'LIKE', $q);
            return $query;
        })
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page') ?: 4);
        return BlogResource::collection($blogs);
    }

    public function show($id)
    {
        $blog = Blog::withCount('likes')->find($id);
        if(!$blog)
        {
            return response([], 404);
        }
        return new BlogResource($blog);
    }
}
