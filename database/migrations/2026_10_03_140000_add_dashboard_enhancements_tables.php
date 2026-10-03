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
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('user_type');
            });
        }

        if (!Schema::hasColumn('authors', 'is_active')) {
            Schema::table('authors', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('following_count');
                $table->string('twitter')->nullable()->after('is_active');
                $table->string('linkedin')->nullable()->after('twitter');
                $table->string('github')->nullable()->after('linkedin');
                $table->string('website')->nullable()->after('github');
            });
        }

        if (!Schema::hasColumn('articles', 'tags')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('tags')->nullable()->after('body');
            });
        }

        if (!Schema::hasColumn('home_settings', 'site_name')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->string('site_name')->default('BlogHub')->after('id');
                $table->text('site_description')->nullable()->after('site_name');
                $table->boolean('auto_approve_comments')->default(false)->after('site_description');
                $table->boolean('auto_approve_posts')->default(false)->after('auto_approve_comments');
                $table->boolean('allow_author_registration')->default(true)->after('auto_approve_posts');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasColumn('authors', 'is_active')) {
            Schema::table('authors', function (Blueprint $table) {
                $table->dropColumn(['is_active', 'twitter', 'linkedin', 'github', 'website']);
            });
        }

        if (Schema::hasColumn('articles', 'tags')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('tags');
            });
        }

        if (Schema::hasColumn('home_settings', 'site_name')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->dropColumn(['site_name', 'site_description', 'auto_approve_comments', 'auto_approve_posts', 'allow_author_registration']);
            });
        }
    }
};
