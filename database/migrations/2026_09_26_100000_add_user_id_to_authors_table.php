<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });

        $this->backfill();
    }

    /**
     * Link existing author rows to user accounts by name, then create a public
     * author profile for every author-type user that still has none.
     */
    protected function backfill(): void
    {
        foreach (DB::table('authors')->whereNull('user_id')->get() as $author) {
            $userId = DB::table('users')->where('name', $author->name)->value('id');

            if ($userId && !DB::table('authors')->where('user_id', $userId)->exists()) {
                DB::table('authors')->where('id', $author->id)->update(['user_id' => $userId]);
            }
        }

        $authorUsers = DB::table('users')
            ->where('user_type', 2)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('authors')
                    ->whereColumn('authors.user_id', 'users.id');
            })
            ->get();

        foreach ($authorUsers as $user) {
            $base = Str::slug($user->name) ?: 'author';
            $slug = $base;
            $i = 1;

            while (DB::table('authors')->where('slug', $slug)->exists()) {
                $slug = $base . '-' . (++$i);
            }

            DB::table('authors')->insert([
                'user_id' => $user->id,
                'name' => $user->name,
                'slug' => $slug,
                'tagline' => $user->niche ? $user->niche . ' Contributor' : 'BlogHub Author',
                'bio' => $user->about ?: 'Contributing author on BlogHub.',
                'specialty' => $user->niche ?: 'General Topics',
                'followers_count' => 0,
                'following_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('user_id');
        });
    }
};
