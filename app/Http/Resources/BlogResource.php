<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id'            => $this->id,
      'title'         => $this->title,
      'body'          => $this->body,
      'author'        => $this->author->name,
      'image_url'     => $this->image_path,
      'created_at'    => $this->created_at ? $this->created_at->format('Y-m-d') : '',
      'published_at'  => $this->published_at ? $this->published_at->format('Y-m-d') : '',
      'liked_by_me'   => $this->hasLiked(),
      'likes_count'   => $this->likes_count,
    ];
  }
}
