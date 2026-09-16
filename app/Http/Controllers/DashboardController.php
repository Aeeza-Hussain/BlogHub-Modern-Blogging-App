<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\Comment;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();
        $totalViews = Article::sum('views_count');
        $totalLikes = Article::sum('likes_count');
        $totalComments = Comment::count();

        $recentArticles = Article::with(['category', 'author'])
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('articles')->get();

        return view('admin.index', compact(
            'totalArticles',
            'totalViews',
            'totalLikes',
            'totalComments',
            'recentArticles',
            'categories'
        ));
    }

    public function articles(Request $request)
    {
        $query = Article::with(['category', 'author']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->input('status') === 'trending') {
                $query->where('is_trending', true);
            }
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.articles', compact('articles', 'categories'));
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('dashboard.articles')->with('success', 'Article deleted successfully!');
    }

    public function charts()
    {
        $categories = Category::withCount('articles')->get();
        $categoryNames = $categories->pluck('name');
        $categoryCounts = $categories->pluck('articles_count');

        $topArticles = Article::orderBy('views_count', 'desc')->take(5)->get();

        return view('admin.charts', compact('categoryNames', 'categoryCounts', 'topArticles'));
    }

    public function account()
    {
        $author = Author::first();
        return view('admin.account', compact('author'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function notifications()
    {
        $messages = ContactMessage::latest()->take(10)->get();
        $comments = Comment::with('article')->latest()->take(10)->get();

        return view('admin.notifications', compact('messages', 'comments'));
    }

    public function help()
    {
        return view('admin.help');
    }
}
