<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
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
        // Hero / Featured article
        $heroArticle = Article::with(['category', 'author'])
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        if (!$heroArticle) {
            $heroArticle = Article::with(['category', 'author'])
                ->orderBy('views_count', 'desc')
                ->first();
        }

        $excludedIds = $heroArticle ? [$heroArticle->id] : [];

        // Trending articles (top engagement)
        $trendingArticles = Article::with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->where('is_trending', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        if ($trendingArticles->count() < 4) {
            $additionalTrending = Article::with(['category', 'author'])
                ->whereNotIn('id', array_merge($excludedIds, $trendingArticles->pluck('id')->toArray()))
                ->orderBy('views_count', 'desc')
                ->take(4 - $trendingArticles->count())
                ->get();
            $trendingArticles = $trendingArticles->merge($additionalTrending);
        }

        $excludedIds = array_merge($excludedIds, $trendingArticles->pluck('id')->toArray());

        // Latest published articles for main section grid
        $latestArticles = Article::with(['category', 'author'])
            ->whereNotIn('id', $excludedIds)
            ->latest('published_at')
            ->take(6)
            ->get();

        // Categories with count
        $categories = Category::withCount('articles')->get();

        // Top authors with count
        $featuredAuthors = Author::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(4)
            ->get();

        // Stats counter
        $stats = [
            'total_articles' => Article::count(),
            'total_views' => Article::sum('views_count'),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
        ];

        return view('home', compact(
            'heroArticle',
            'trendingArticles',
            'latestArticles',
            'categories',
            'featuredAuthors',
            'stats'
        ));
    }
}

