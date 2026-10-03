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
        if ($homeSetting && $homeSetting->featured_article_id && $homeSetting->featuredArticle && $homeSetting->featuredArticle->isApproved()) {
            $heroArticle = $homeSetting->featuredArticle;
        } else {
            $heroArticle = Article::approved()->with(['category', 'author'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->first();

            if (!$heroArticle) {
                $heroArticle = Article::approved()->with(['category', 'author'])
                    ->latest('published_at')
                    ->first();
            }
        }

        $excludedIds = $heroArticle ? [$heroArticle->id] : [];

        // 2. Trending articles (Strictly approved articles marked is_trending)
        $trendingArticles = Article::approved()->with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->where('is_trending', true)
            ->latest('published_at')
            ->take(8)
            ->get();
            
        if ($trendingArticles->count() < 4) {
            $moreTrending = Article::approved()->with(['category', 'author'])
                ->whereNotIn('id', $excludedIds)
                ->whereNotIn('id', $trendingArticles->pluck('id')->toArray())
                ->orderBy('views_count', 'desc')
                ->latest('published_at')
                ->take(8 - $trendingArticles->count())
                ->get();
            $trendingArticles = $trendingArticles->concat($moreTrending);
        }

        // 3. Latest published articles for main section grid
        $latestArticles = Article::approved()->with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->whereNotIn('id', $trendingArticles->pluck('id')->toArray())
            ->latest('published_at')
            ->take(6)
            ->get();

        // 4. Categories with approved article count
        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])->get();

        // 5. Authors with approved article count
        $featuredAuthors = Author::withCount(['articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])
            ->orderBy('articles_count', 'desc')
            ->take(8)
            ->get();

        // Stats counter
        $stats = [
            'total_articles' => Article::approved()->count(),
            'total_views' => Article::approved()->sum('views_count'),
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

