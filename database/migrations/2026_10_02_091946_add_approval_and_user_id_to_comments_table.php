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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('article_id')->constrained('users')->nullOnDelete();
            $table->boolean('is_approved')->default(false)->after('content');
            $table->index('is_approved');
        });

        // Mark existing comments as approved so legacy content remains intact
        \Illuminate\Support\Facades\DB::table('comments')->update(['is_approved' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['is_approved']);
            $table->dropColumn(['user_id', 'is_approved']);
        });
    }
};
