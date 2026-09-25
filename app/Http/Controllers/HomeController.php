<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Home Settings (Hero text & promo configured from Dashboard)
        $homeSetting = HomeSetting::with(['featuredArticle.category', 'featuredArticle.author'])->first();

        // Hero / Featured article
        $heroArticle = null;
        if ($homeSetting && $homeSetting->featured_article_id && $homeSetting->featuredArticle) {
            $heroArticle = $homeSetting->featuredArticle;
        } else {
            $heroArticle = Article::with(['category', 'author'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->first();

            if (!$heroArticle) {
                $heroArticle = Article::with(['category', 'author'])
                    ->latest()
                    ->first();
            }
        }

        $excludedIds = $heroArticle ? [$heroArticle->id] : [];

        // 2. Trending articles (Strictly articles marked is_trending from Dashboard)
        $trendingArticles = Article::with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->where('is_trending', true)
            ->latest('published_at')
            ->take(8)
            ->get();

        // 3. Latest published articles for main section grid
        $latestArticles = Article::with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->latest('published_at')
            ->take(6)
            ->get();

        // 4. Categories with article count
        $categories = Category::withCount('articles')->get();

        // 5. Authors with article count
        $featuredAuthors = Author::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(8)
            ->get();

        // Stats counter
        $stats = [
            'total_articles' => Article::count(),
            'total_views' => Article::sum('views_count'),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
        ];

        return view('Frontend.home', compact(
            'homeSetting',
            'heroArticle',
            'trendingArticles',
            'latestArticles',
            'categories',
            'featuredAuthors',
            'stats'
        ));
    }
}

