<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'avatar',
        'cover_image',
        'tagline',
        'bio',
        'specialty',
        'followers_count',
        'following_count',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * The login account that owns this public author profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
