<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('blogs', function (Blueprint $table) {
      $table->unsignedBigInteger('id');
      $table->unsignedBigInteger('user_id')->index();
      $table->string('title');
      $table->text('body')->nullable();
      $table->string('image_path')->default('');
      $table->date('published_at')->index();
      $table->timestamps();
      $table->primary(['id', 'published_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blogs');
  }
};
