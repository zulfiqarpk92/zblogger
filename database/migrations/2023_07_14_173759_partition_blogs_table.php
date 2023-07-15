<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    $last_six_months = Carbon::now()->subMonths(6)->format('Y-m-d');
    DB::statement("ALTER TABLE blogs PARTITION BY RANGE (TO_DAYS(published_at)) (
        PARTITION past_records VALUES LESS THAN (TO_DAYS(\"$last_six_months\")),
        PARTITION current_records VALUES LESS THAN MAXVALUE
    );");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("ALTER TABLE blogs REMOVE PARTITIONING");
  }
};
