<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'auto_approve_comments',
        'auto_approve_posts',
        'allow_author_registration',
        'hero_badge',
        'hero_heading',
        'hero_description',
        'promo_heading',
        'promo_subheading',
        'promo_description',
        'promo_btn_text',
        'promo_btn_url',
        'featured_article_id',
    ];

    protected $casts = [
        'auto_approve_comments' => 'boolean',
        'auto_approve_posts' => 'boolean',
        'allow_author_registration' => 'boolean',
    ];

    public function featuredArticle()
    {
        return $this->belongsTo(Article::class, 'featured_article_id');
    }
}
