<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogLikeController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $blog = Blog::withCount('likes')->find($id);
        if ($blog->likes()->where('user_id', auth()->id())->exists()) {
            $blog->likes()->detach(Auth::user());
        } else {
            $blog->likes()->attach(Auth::user());
        }
        $blog = Blog::withCount('likes')->find($id);
        return new BlogResource($blog);
    }
}
