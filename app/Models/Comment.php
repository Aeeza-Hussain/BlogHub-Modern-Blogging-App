<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_name',
        'user_avatar',
        'content',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
