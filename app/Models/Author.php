<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
