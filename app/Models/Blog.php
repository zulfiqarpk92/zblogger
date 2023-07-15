<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
  use HasFactory;

  protected $fillable = [
    'id',
    'user_id',
    'title',
    'body',
    'image_path',
    'published_at'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'published_at' => 'datetime',
  ];

  public function getImagePathAttribute($value): string
  {
    if(!$value) return '';
    return Storage::disk('s3')->temporaryUrl($value, now()->addHour());
  }

  public function author(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function likes(): BelongsToMany
  {
    return $this->BelongsToMany(User::class, 'blog_likes');
  }

  public function hasLiked()
  {
    $user_id = auth('sanctum')->id();
    return $this->likes()->where('user_id', $user_id)->exists();
  }

}
