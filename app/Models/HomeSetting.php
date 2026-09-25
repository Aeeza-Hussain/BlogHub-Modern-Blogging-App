<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
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

    public function featuredArticle()
    {
        return $this->belongsTo(Article::class, 'featured_article_id');
    }
}
