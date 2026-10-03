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
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique()->index();
                $table->text('value')->nullable();
                $table->string('group')->default('general')->index();
                $table->string('type')->default('string');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('comments') && !Schema::hasColumn('comments', 'parent_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->foreignId('parent_id')->nullable()->after('article_id')->constrained('comments')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('comments') && Schema::hasColumn('comments', 'parent_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            });
        }

        Schema::dropIfExists('settings');
    }
};
