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
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact', 30)->nullable()->after('email');
            $table->string('gender', 20)->nullable()->after('contact');
            $table->date('dob')->nullable()->after('gender');
            $table->string('image')->nullable()->after('dob');
            $table->text('about')->nullable()->after('image');
            $table->string('niche', 100)->nullable()->after('about');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['contact', 'gender', 'dob', 'image', 'about', 'niche']);
        });
    }
};
