<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display listing of articles with search, category filter, author filter, sorting.
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author']);

        // Filter by Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by Category Slug
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter by Author Slug
        if ($request->filled('author')) {
            $authorSlug = $request->author;
            $query->whereHas('author', function($q) use ($authorSlug) {
                $q->where('slug', $authorSlug);
            });
        }

        // Sort Order
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->latest();
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = Category::withCount('articles')->get();
        $authors = Author::withCount('articles')->get();

        return view('blogs.index', compact('articles', 'categories', 'authors'));
    }

    /**
     * Show single article page.
     */
    public function show($slug)
    {
        $article = Article::with(['category', 'author', 'comments'])->where('slug', $slug)->firstOrFail();

        // Increment view count
        $article->increment('views_count');

        // Fetch 3 related posts in same category or latest
        $relatedArticles = Article::with(['category', 'author'])
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest()
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $relatedArticles = Article::with(['category', 'author'])
                ->where('id', '!=', $article->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('blogs.show', compact('article', 'relatedArticles'));
    }

    /**
     * Show form for creating a new article (CRUD).
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $user = auth()->user();

        // Admins publish on behalf of any author; authors publish as themselves.
        $author = $user->ensureAuthorProfile();
        $authors = $user->isAdmin() ? Author::orderBy('name')->get() : collect();

        return view('blogs.create', compact('categories', 'authors', 'author'));
    }

    /**
     * Store a newly created article in storage (CRUD).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'featured_image' => 'nullable|url|max:2048',
            'reading_time' => 'nullable|integer|min:1|max:60',
        ];

        // Only admins may post under someone else's byline.
        if ($user->isAdmin()) {
            $rules['author_id'] = 'nullable|exists:authors,id';
        }

        $validated = $request->validate($rules, [
            'category_id.required' => 'Please choose a category for your article.',
            'category_id.exists' => 'The selected category no longer exists.',
            'excerpt.required' => 'Please add a short summary so the post looks good in listings.',
            'body.required' => 'The article body cannot be empty.',
            'featured_image.url' => 'The cover image must be a valid image URL.',
        ]);

        // articles.author_id is a foreign key to authors.id, so it must be the
        // author profile id, never the users table id.
        if ($user->isAdmin() && !empty($validated['author_id'])) {
            $author = Author::findOrFail($validated['author_id']);
        } else {
            $author = $user->ensureAuthorProfile();
        }

        $article = new Article();
        $article->title = $validated['title'];
        $article->slug = $this->uniqueSlug($validated['title']);
        $article->category_id = $validated['category_id'];
        $article->author_id = $author->id;
        $article->excerpt = $validated['excerpt'];
        $article->body = $validated['body'];
        $article->featured_image = $validated['featured_image'] ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80';
        $article->reading_time = $validated['reading_time'] ?? 5;
        $article->views_count = 0;
        $article->likes_count = 0;
        $article->published_at = now();
        $article->save();

        return redirect()->route('blogs.show', $article->slug)->with('success', 'Article published successfully!');
    }

    /**
     * Build a slug that is guaranteed not to collide with an existing article.
     */
    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }

    /**
     * Store comment for an article.
     */
    public function storeComment(Request $request, $id)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->article_id = $id;
        $comment->user_name = $validated['user_name'];
        $comment->user_avatar = 'https://i.pravatar.cc/150?u=' . urlencode($validated['user_name']);
        $comment->content = $validated['content'];
        $comment->save();

        return redirect()->back()->with('success', 'Your comment has been added!');
    }

    /**
     * Like article action.
     */
    public function like($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('likes_count');

        if (request()->wantsJson()) {
            return response()->json(['likes_count' => $article->likes_count]);
        }

        return redirect()->back()->with('success', 'Liked article!');
    }
}
