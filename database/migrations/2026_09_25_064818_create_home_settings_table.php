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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge')->default('Premier Content Hub');
            $table->string('hero_heading')->default('Discover Thoughtful Stories & Expert Perspectives');
            $table->text('hero_description')->nullable();
            $table->string('promo_heading')->default('Share Your Knowledge');
            $table->string('promo_subheading')->default('Join 10,000+ creators on BlogHub');
            $table->text('promo_description')->nullable();
            $table->string('promo_btn_text')->default('Write Article');
            $table->string('promo_btn_url')->default('/blogs/create');
            $table->foreignId('featured_article_id')->nullable()->constrained('articles')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
