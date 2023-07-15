<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogLike extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id', 'blog_id'
  ];

  public function blog(): BelongsTo
  {
    return $this->belongsTo(Blog::class);
  }
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
