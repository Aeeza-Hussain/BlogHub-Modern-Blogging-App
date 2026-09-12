<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArticles = Article::with(['category', 'author'])
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        $trendingArticles = Article::with(['category', 'author'])
            ->where('is_trending', true)
            ->latest()
            ->take(4)
            ->get();

        $latestArticles = Article::with(['category', 'author'])
            ->latest()
            ->paginate(6);

        $categories = Category::withCount('articles')->take(10)->get();
        $authors = Author::withCount('articles')->take(6)->get();

        $stats = [
            'total_articles' => Article::count(),
            'total_authors' => Author::count(),
            'total_readers' => 45800,
            'total_categories' => Category::count(),
        ];

        return view('home', compact('featuredArticles', 'trendingArticles', 'latestArticles', 'categories', 'authors', 'stats'));
    }
}
