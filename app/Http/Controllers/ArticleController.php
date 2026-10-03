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
        $query = Article::approved()->with(['category', 'author']);

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
            $query->oldest('published_at');
        } elseif ($sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->latest('published_at');
        }

        $articles = $query->paginate((int) setting('posts_per_page', 9))->withQueryString();
        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])->get();
        $authors = Author::withCount(['articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])->get();

        return view('blogs.index', compact('articles', 'categories', 'authors'));
    }

    /**
     * Show single article page.
     */
    public function show($slug)
    {
        $article = Article::with(['category', 'author', 'comments', 'rootComments.approvedReplies'])->where('slug', $slug)->firstOrFail();

        // If article is not approved, only admin or the author owner may preview it
        if (!$article->isApproved()) {
            $user = auth()->user();
            $canPreview = false;
            if ($user) {
                if ($user->isAdmin()) {
                    $canPreview = true;
                } else {
                    $author = $user->author;
                    if ($author && $author->id === $article->author_id) {
                        $canPreview = true;
                    }
                }
            }
            if (!$canPreview) {
                abort(404);
            }
        } else {
            // Increment view count for approved articles only
            $article->increment('views_count');
        }

        // Fetch 3 related posts in same category or latest (approved only)
        $relatedArticles = Article::approved()->with(['category', 'author'])
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $relatedArticles = Article::approved()->with(['category', 'author'])
                ->where('id', '!=', $article->id)
                ->latest('published_at')
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
        $user = auth()->user();

        // Admin does not create articles; authors create and submit for admin approval
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.all-articles')
                ->with('error', 'Administrators cannot create articles. Articles are written by authors and submitted for admin approval.');
        }

        $categories = Category::orderBy('name')->get();
        $author = $user->ensureAuthorProfile();
        $authors = collect();

        return view('blogs.create', compact('categories', 'authors', 'author'));
    }

    /**
     * Store a newly created article in storage (CRUD).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Admin does not create articles
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.all-articles')
                ->with('error', 'Administrators cannot create articles. Articles are written by authors and submitted for admin approval.');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'reading_time' => 'nullable|integer|min:1|max:60',
        ];

        $validated = $request->validate($rules, [
            'category_id.required' => 'Please choose a category for your article.',
            'category_id.exists' => 'The selected category no longer exists.',
            'excerpt.required' => 'Please add a short summary so the post looks good in listings.',
            'body.required' => 'The article body cannot be empty.',
            'featured_image.image' => 'The cover image must be a valid image file.',
        ]);

        $author = $user->ensureAuthorProfile();

        $article = new Article();
        $article->title = $validated['title'];
        $article->slug = $this->uniqueSlug($validated['title']);
        $article->category_id = $validated['category_id'];
        $article->author_id = $author->id;
        
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image = asset('storage/' . $imagePath);
        } else {
            // Default aesthetic placeholder to prevent broken images
            $article->featured_image = 'https://ui-avatars.com/api/?name=' . urlencode($validated['title']) . '&background=random&color=ffffff&size=1200';
        }

        $article->excerpt = $validated['excerpt'];
        $article->body = $validated['body'];
        $article->tags = $request->input('tags');
        $article->reading_time = $validated['reading_time'] ?? 5;
        $article->views_count = 0;
        $article->likes_count = 0;

        // Check if saved as draft or submitted for review
        $isDraft = $request->input('action') === 'draft';
        if ($isDraft) {
            $article->status = Article::STATUS_DRAFT;
            $article->published_at = null;
            $article->save();
            return redirect()->route('dashboard.articles')->with('success', 'Your article has been saved as a draft. You can continue writing and submit it for review whenever you are ready!');
        }

        $article->status = Article::STATUS_PENDING;
        $article->published_at = null;
        $article->save();

        return redirect()->route('dashboard.articles')->with('success', 'Your article has been submitted for review! It has been sent to the administrator and will be published on the website once approved.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();
        $author = $user->ensureAuthorProfile();

        // Check ownership if not admin
        if (!$user->isAdmin()) {
            if ($article->author_id !== $author->id) {
                abort(403, 'Unauthorized action. You can only edit your own articles.');
            }
        }

        $categories = Category::orderBy('name')->get();
        $authors = $user->isAdmin() ? Author::orderBy('name')->get() : collect();

        return view('Frontend.blogs.edit', compact('article', 'categories', 'authors', 'author'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();
        $author = $user->ensureAuthorProfile();

        // Check ownership if not admin
        if (!$user->isAdmin()) {
            if ($article->author_id !== $author->id) {
                abort(403, 'Unauthorized action. You can only edit your own articles.');
            }
        }

        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'reading_time' => 'nullable|integer|min:1|max:60',
        ];

        if ($user->isAdmin()) {
            $rules['author_id'] = 'nullable|exists:authors,id';
        }

        $validated = $request->validate($rules, [
            'category_id.required' => 'Please choose a category for your article.',
            'excerpt.required' => 'Please add a short summary so the post looks good in listings.',
            'body.required' => 'The article body cannot be empty.',
            'featured_image.image' => 'The cover image must be a valid image file.',
        ]);

        if ($user->isAdmin() && !empty($validated['author_id'])) {
            $author = Author::findOrFail($validated['author_id']);
        }

        $article->title = $validated['title'];
        $article->category_id = $validated['category_id'];
        $article->author_id = $author->id;
        $article->tags = $request->input('tags');
        
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image = asset('storage/' . $imagePath);
        }

        $article->excerpt = $validated['excerpt'];
        $article->body = $validated['body'];
        $article->reading_time = $validated['reading_time'] ?? 5;

        $isDraft = $request->input('action') === 'draft';

        if (!$user->isAdmin()) {
            if ($isDraft) {
                $article->status = Article::STATUS_DRAFT;
                $article->save();
                return redirect()->route('dashboard.articles')->with('success', 'Article updated and saved as draft.');
            }

            $article->status = Article::STATUS_PENDING;
            $article->rejection_reason = null;
            $article->save();

            return redirect()->route('dashboard.articles')->with('success', 'Article updated and submitted for administrator approval!');
        }

        if ($isDraft) {
            $article->status = Article::STATUS_DRAFT;
        }

        $article->save();

        return redirect()->route('dashboard.all-articles')->with('success', 'Article updated successfully!');
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
        // 1. Check if comments are enabled platform-wide
        if (!setting('enable_comments', true)) {
            return redirect()->back()->with('error', 'Comments are currently disabled across the platform.');
        }

        $user = auth()->user();
        $requireAuth = (bool) setting('require_auth_comments', true);

        if ($requireAuth && !$user) {
            return redirect()->route('login')->with('error', 'Please login or register with an account to leave a comment.');
        }

        $rules = [
            'content' => 'required|string|min:2|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ];

        if (!$user) {
            $rules['user_name'] = 'required|string|max:80';
        }

        $validated = $request->validate($rules, [
            'content.required' => 'Please write your comment before submitting.',
            'user_name.required' => 'Please enter your name.',
        ]);

        $article = Article::findOrFail($id);

        $comment = new Comment();
        $comment->article_id = $article->id;

        // Support nested replies if enabled
        if (setting('enable_comment_replies', true) && !empty($validated['parent_id'])) {
            $parent = Comment::where('article_id', $article->id)->find($validated['parent_id']);
            if ($parent) {
                $comment->parent_id = $parent->parent_id ?: $parent->id;
            }
        }

        if ($user) {
            $comment->user_id = $user->id;
            $comment->user_name = $user->name;
            $comment->user_avatar = $user->avatar_url;
        } else {
            $comment->user_id = null;
            $comment->user_name = $validated['user_name'];
            $comment->user_avatar = 'https://ui-avatars.com/api/?name=' . urlencode($validated['user_name']) . '&background=C8461F&color=fff&bold=true';
        }

        $comment->content = $validated['content'];

        // Moderation logic:
        $moderationEnabled = (bool) setting('enable_comment_moderation', false);
        $isAuthorOfArticle = $user && (($user->author && $user->author->id === $article->author_id) || $user->isAdmin());

        if (!$moderationEnabled) {
            // Moderation OFF -> auto-approved immediately
            $comment->is_approved = true;
        } else {
            // Moderation ON -> author/admin auto-approved, others need review
            $comment->is_approved = $isAuthorOfArticle;
        }

        $comment->save();

        if ($comment->is_approved) {
            return redirect()->back()->with('success', 'Your comment has been posted!');
        }

        return redirect()->back()->with('success', 'Thank you! Your comment has been submitted for review and will appear once approved by the author.');
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
