<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
  public function index(Request $request)
  {
    $order_column = $request->get('orderBy');
    if (!in_array($order_column, ['id', 'title', 'published_at', 'created_at'])) {
      $order_column = 'id';
    }
    $q =  '%' . $request->input('q') . '%';
    $blogs = Blog::withCount('likes')->where('user_id', Auth::id())->where(function ($query) use ($q){
      $query->where('title', 'LIKE', $q)
        ->orWhere('body', 'LIKE', $q);
    })
      ->orderBy($order_column, $request->boolean('orderDesc') ? 'desc' : 'asc')
      ->paginate($request->get('per_page'));
    return BlogResource::collection($blogs);
  }

  public function store(BlogRequest $request)
  {
    $validated = $request->validated();
    $image_path = $request->file('file')->store('images', 's3');
    $blog = new Blog($validated);
    $blog->id = Blog::max('id') + 1;
    $blog->user_id = Auth::id();
    $blog->published_at = date('Y-m-d');
    $blog->image_path = $image_path;
    $blog->save();

    return response()->json([
      'status'  => 'success',
      'message' => 'Blog added successfully.',
      'data'    => ['blog_id' => $blog->id]
    ]);
  }

  public function update($id, BlogRequest $request)
  {
    $image_path = null;
    if($request->hasFile('file'))
    {
      $image_path = $request->file('file')->store('images', 's3');
    }
    $blog = Blog::find($id);
    $blog->title = $request->input('title');
    $blog->body = $request->input('body');
    $blog->published_at = date('Y-m-d');
    if($image_path)
    {
      $blog->image_path = $image_path;
    }
    $blog->save();

    return response()->json([
      'status'  => 'success',
      'message' => 'Blog updated successfully.',
      'data'    => ['blog_id' => $blog->id]
    ]);
  }

  public function show($id)
  {
    $blog = Blog::find($id);
    return response()->json($blog);
  }

  public function destroy($id)
  {
    $blog = Blog::find($id);
    $blog->delete();
    return response()->json([
      'status'  => 'success',
      'message' => "Blog $blog->title deleted successfully.",
      'data'    => ['blog_id' => $id]
    ]);
  }
}
