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
        // 1. Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('fa-folder');
            $table->text('description')->nullable();
            $table->string('color')->default('#C8461F');
            $table->timestamps();
        });

        // 2. Authors Table
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->string('specialty')->default('Staff Writer');
            $table->integer('followers_count')->default(120);
            $table->integer('following_count')->default(45);
            $table->timestamps();
        });

        // 3. Articles Table
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('body');
            $table->string('featured_image');
            $table->integer('reading_time')->default(5);
            $table->integer('views_count')->default(150);
            $table->integer('likes_count')->default(25);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 4. Comments Table
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->string('user_name');
            $table->string('user_avatar')->nullable();
            $table->text('content');
            $table->timestamps();
        });

        // 5. Contact Messages Table
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('categories');
    }
};
