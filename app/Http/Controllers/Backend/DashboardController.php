<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\HomeSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

        return view('backend.index', compact(
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

        return view('backend.articles', compact('articles', 'categories'));
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $user = request()->user();

        // Authors may only remove their own posts; admins may remove any.
        if (!$user->isAdmin() && $article->author_id !== $user->ensureAuthorProfile()->id) {
            abort(403, 'You can only delete your own articles.');
        }

        $article->delete();

        return redirect()->route('dashboard.articles')->with('success', 'Article deleted successfully!');
    }

    public function charts()
    {
        $categories = Category::withCount('articles')->get();
        $categoryNames = $categories->pluck('name');
        $categoryCounts = $categories->pluck('articles_count');

        $topArticles = Article::orderBy('views_count', 'desc')->take(5)->get();

        return view('backend.charts', compact('categoryNames', 'categoryCounts', 'topArticles'));
    }

    public function account()
    {
        $author = request()->user()->ensureAuthorProfile();
        return view('backend.account', compact('author'));
    }

    public function settings()
    {
        return view('backend.settings');
    }

    public function notifications()
    {
        $messages = ContactMessage::latest()->take(10)->get();
        $comments = Comment::with('article')->latest()->take(10)->get();

        return view('backend.notifications', compact('messages', 'comments'));
    }

    public function help()
    {
        return view('backend.help');
    }

    public function website()
    {
        return $this->websiteSection('all');
    }

    public function websiteSection($section = 'all')
    {
        $homeSetting = HomeSetting::firstOrCreate([], [
            'hero_badge' => 'Premier Content Hub',
            'hero_heading' => 'Discover Thoughtful Stories & Expert Perspectives',
            'hero_description' => 'Explore curated articles on technology, design, science, business, and culture. Written by passionate creators and industry experts.',
            'promo_heading' => 'Share Your Knowledge',
            'promo_subheading' => 'Join 10,000+ creators on BlogHub',
            'promo_description' => 'Publish your articles, connect with readers, and grow your audience with our powerful blogging platform tools.',
            'promo_btn_text' => 'Write Article',
            'promo_btn_url' => '/blogs/create',
        ]);

        $heroArticle = null;
        if ($homeSetting->featured_article_id) {
            $heroArticle = Article::with(['category', 'author'])->find($homeSetting->featured_article_id);
        }
        if (!$heroArticle) {
            $heroArticle = Article::with(['category', 'author'])
                ->where('is_featured', true)
                ->first() ?? Article::latest()->first();
        }

        $allArticles = Article::with('category')->latest()->get();

        $trendingArticles = Article::with(['category', 'author'])
            ->where('is_trending', true)
            ->get();

        $categories = Category::withCount('articles')->latest()->get();

        $latestArticles = Article::with(['category', 'author'])
            ->latest()
            ->take(12)
            ->get();

        $featuredAuthors = Author::withCount('articles')
            ->latest()
            ->get();

        $totalViews = Article::sum('views_count');
        $totalArticles = Article::count();
        $totalAuthors = Author::count();
        $totalCategories = Category::count();

        return view('backend.website.index', compact(
            'section',
            'homeSetting',
            'heroArticle',
            'allArticles',
            'trendingArticles',
            'categories',
            'latestArticles',
            'featuredAuthors',
            'totalViews',
            'totalArticles',
            'totalAuthors',
            'totalCategories'
        ));
    }

    public function updateHeroSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'required|string|max:100',
            'hero_heading' => 'required|string|max:255',
            'hero_description' => 'required|string|max:1000',
            'promo_heading' => 'nullable|string|max:150',
            'promo_subheading' => 'nullable|string|max:150',
            'promo_description' => 'nullable|string|max:500',
            'promo_btn_text' => 'nullable|string|max:50',
            'promo_btn_url' => 'nullable|string|max:255',
            'featured_article_id' => 'nullable|exists:articles,id',
        ]);

        $homeSetting = HomeSetting::first();
        if (!$homeSetting) {
            $homeSetting = new HomeSetting();
        }

        $homeSetting->fill($validated);
        $homeSetting->save();

        if (!empty($validated['featured_article_id'])) {
            Article::where('is_featured', true)->update(['is_featured' => false]);
            Article::where('id', $validated['featured_article_id'])->update(['is_featured' => true]);
        }

        return redirect()->route('dashboard.website.section', 'discover')->with('success', 'Hero and Discover section settings updated successfully!');
    }

    public function toggleTrending(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->is_trending = !$article->is_trending;
        $article->save();

        $statusText = $article->is_trending ? 'marked as Trending' : 'removed from Trending';
        $message = "\"{$article->title}\" is now {$statusText}.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_trending' => $article->is_trending,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:30',
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'icon' => $validated['icon'] ?: 'fa-folder',
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?: '#C8461F',
        ]);

        return redirect()->route('dashboard.website.section', 'topics')->with('success', 'New Category added successfully!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:30',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?: 'fa-folder',
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?: '#C8461F',
        ]);

        return redirect()->route('dashboard.website.section', 'topics')->with('success', "Category \"{$category->name}\" updated successfully!");
    }

    public function deleteCategory($id)
    {
        $category = Category::withCount('articles')->findOrFail($id);
        $name = $category->name;
        $category->delete();

        return redirect()->route('dashboard.website.section', 'topics')->with('success', "Category \"{$name}\" deleted successfully!");
    }

    public function storeAuthor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'specialty' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:200',
            'bio' => 'nullable|string|max:1000',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'avatar_url' => 'nullable|string|max:500',
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Author::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        $avatar = null;
        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $avatar = asset('storage/' . $path);
        } elseif (!empty($validated['avatar_url'])) {
            $avatar = $validated['avatar_url'];
        } else {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&background=C8461F&color=ffffff&bold=true';
        }

        Author::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'avatar' => $avatar,
            'specialty' => $validated['specialty'] ?: 'Contributing Author',
            'tagline' => $validated['tagline'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'followers_count' => rand(15, 80),
            'following_count' => rand(5, 30),
        ]);

        return redirect()->route('dashboard.website.section', 'authors')->with('success', 'New Author added successfully!');
    }

    public function updateAuthor(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'specialty' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:200',
            'bio' => 'nullable|string|max:1000',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'avatar_url' => 'nullable|string|max:500',
        ]);

        $avatar = $author->avatar;
        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $avatar = asset('storage/' . $path);
        } elseif (!empty($validated['avatar_url'])) {
            $avatar = $validated['avatar_url'];
        }

        $author->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'avatar' => $avatar,
            'specialty' => $validated['specialty'] ?: $author->specialty,
            'tagline' => $validated['tagline'] ?? $author->tagline,
            'bio' => $validated['bio'] ?? $author->bio,
        ]);

        return redirect()->route('dashboard.website.section', 'authors')->with('success', "Author \"{$author->name}\" updated successfully!");
    }

    public function deleteAuthor($id)
    {
        $author = Author::findOrFail($id);
        $name = $author->name;
        $author->delete();

        return redirect()->route('dashboard.website.section', 'authors')->with('success', "Author \"{$name}\" deleted successfully!");
    }
}
