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
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /* ============================================================
     * 1. DASHBOARD OVERVIEW (Role Differentiated)
     * ============================================================ */

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // ADMIN OVERVIEW
            $totalUsers = User::count();
            $totalAuthors = Author::count();
            $totalArticles = Article::count();
            $publishedArticles = Article::approved()->count();
            $draftArticles = Article::draft()->count();
            $pendingArticlesCount = Article::pending()->count();
            $rejectedArticlesCount = Article::rejected()->count();
            $totalComments = Comment::count();
            $pendingCommentsCount = Comment::where('is_approved', false)->count();
            $totalCategories = Category::count();
            $totalViews = Article::sum('views_count');

            // Recent Posts with relations
            $recentArticles = Article::with(['category', 'author'])
                ->latest()
                ->take(8)
                ->get();

            // Recent Activities Feed
            $recentActivities = collect();

            // Recent users
            $recentUsers = User::latest()->take(4)->get();
            foreach ($recentUsers as $u) {
                $recentActivities->push([
                    'type' => 'user_registered',
                    'title' => 'New user registered',
                    'description' => "{$u->name} ({$u->email}) joined BlogHub.",
                    'time' => $u->created_at,
                    'icon' => 'fa-user-plus',
                    'color' => '#3b82f6',
                ]);
            }

            // Recent articles
            $recentPosts = Article::with('author')->latest()->take(4)->get();
            foreach ($recentPosts as $p) {
                $authorName = $p->author?->name ?? 'Author';
                $statusLabel = ucfirst($p->status);
                $recentActivities->push([
                    'type' => 'post_created',
                    'title' => "Post {$statusLabel}",
                    'description' => "\"{$p->title}\" by {$authorName}.",
                    'time' => $p->created_at,
                    'icon' => 'fa-file-lines',
                    'color' => $p->status === 'approved' ? '#10b981' : ($p->status === 'pending' ? '#f59e0b' : '#6b7280'),
                ]);
            }

            // Recent comments
            $recentComm = Comment::with('article')->latest()->take(4)->get();
            foreach ($recentComm as $c) {
                $postTitle = $c->article?->title ?? 'an article';
                $recentActivities->push([
                    'type' => 'comment_added',
                    'title' => 'New comment',
                    'description' => "{$c->user_name} commented on \"{$postTitle}\".",
                    'time' => $c->created_at,
                    'icon' => 'fa-comment-dots',
                    'color' => '#8b5cf6',
                ]);
            }

            $recentActivities = $recentActivities->sortByDesc('time')->take(8);

            return view('backend.index', compact(
                'totalUsers',
                'totalAuthors',
                'totalArticles',
                'publishedArticles',
                'draftArticles',
                'pendingArticlesCount',
                'rejectedArticlesCount',
                'totalComments',
                'pendingCommentsCount',
                'totalCategories',
                'totalViews',
                'recentArticles',
                'recentActivities'
            ));
        } else {
            // AUTHOR OVERVIEW (Strictly Author's own content)
            $author = $user->ensureAuthorProfile();
            $authorQuery = Article::where('author_id', $author->id);

            $myTotalArticles = (clone $authorQuery)->count();
            $myPublished = (clone $authorQuery)->approved()->count();
            $myDraft = (clone $authorQuery)->draft()->count();
            $myPending = (clone $authorQuery)->pending()->count();
            $myRejected = (clone $authorQuery)->rejected()->count();
            $myTotalViews = (clone $authorQuery)->sum('views_count');
            
            $myTotalComments = Comment::whereHas('article', function($q) use ($author) {
                $q->where('author_id', $author->id);
            })->count();

            $myRecentArticles = (clone $authorQuery)->with('category')
                ->latest()
                ->take(6)
                ->get();

            $myRecentComments = Comment::whereHas('article', function($q) use ($author) {
                $q->where('author_id', $author->id);
            })->with('article')->latest()->take(5)->get();

            return view('backend.index', compact(
                'author',
                'myTotalArticles',
                'myPublished',
                'myDraft',
                'myPending',
                'myRejected',
                'myTotalViews',
                'myTotalComments',
                'myRecentArticles',
                'myRecentComments'
            ));
        }
    }

    /* ============================================================
     * 2. POST MANAGEMENT (Admin: All Posts / Author: My Posts)
     * ============================================================ */

    /**
     * Admin: Complete Posts Management
     */
    public function allArticles(Request $request)
    {
        $query = Article::with(['category', 'author']);

        $totalArticles   = Article::count();
        $publishedCount  = Article::approved()->count();
        $pendingCount    = Article::pending()->count();
        $draftCount      = Article::draft()->count();
        $rejectedCount   = Article::rejected()->count();
        $totalViews      = Article::sum('views_count');

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('excerpt', 'like', "%{$s}%")
                  ->orWhere('body', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('author')) {
            $query->where('author_id', $request->input('author'));
        }

        if ($request->filled('status')) {
            $st = $request->input('status');
            if (in_array($st, ['draft', 'pending', 'approved', 'rejected'])) {
                $query->where('status', $st);
            }
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->latest();
        }

        $articles   = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $authors    = Author::orderBy('name')->get();

        return view('backend.all-articles', compact(
            'articles', 'categories', 'authors',
            'totalArticles', 'publishedCount', 'pendingCount', 'draftCount', 'rejectedCount', 'totalViews'
        ));
    }

    /**
     * Author: My Posts section (strictly own articles)
     */
    public function articles(Request $request)
    {
        $user = $request->user() ?: auth()->user();
        $author = $user->ensureAuthorProfile();
        $query = Article::where('author_id', $author->id)->with(['category', 'author']);

        $baseQuery = clone $query;
        $totalMyArticles = (clone $baseQuery)->count();
        $publishedCount  = (clone $baseQuery)->where('status', Article::STATUS_APPROVED)->count();
        $pendingCount    = (clone $baseQuery)->where('status', Article::STATUS_PENDING)->count();
        $draftCount      = (clone $baseQuery)->where('status', Article::STATUS_DRAFT)->count();
        $rejectedCount   = (clone $baseQuery)->where('status', Article::STATUS_REJECTED)->count();

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
            $st = $request->input('status');
            if (in_array($st, ['draft', 'pending', 'approved', 'rejected'])) {
                $query->where('status', $st);
            }
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->latest();
        }

        $articles = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('backend.articles', compact(
            'articles',
            'categories',
            'totalMyArticles',
            'publishedCount',
            'pendingCount',
            'draftCount',
            'rejectedCount'
        ));
    }

    /**
     * Submit a draft or rejected article for Admin review
     */
    public function submitArticleForReview($id)
    {
        $article = Article::findOrFail($id);
        $user = request()->user();

        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            if ($article->author_id !== $author->id) {
                abort(403, 'Unauthorized. You can only submit your own articles.');
            }
        }

        $article->status = Article::STATUS_PENDING;
        $article->rejection_reason = null;
        $article->save();

        return redirect()->back()->with('success', "Article \"{$article->title}\" submitted for review! It will be published once an administrator approves it.");
    }

    public function approveArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->status = Article::STATUS_APPROVED;
        $article->rejection_reason = null;
        if (!$article->published_at) {
            $article->published_at = now();
        }
        $article->save();

        return redirect()->back()->with('success', "Article \"{$article->title}\" has been published and is now live on the website!");
    }

    public function rejectArticle(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $article = Article::findOrFail($id);
        $article->status = Article::STATUS_REJECTED;
        $article->rejection_reason = $validated['reason'] ?? 'Does not meet editorial guidelines.';
        $article->save();

        return redirect()->back()->with('success', "Article \"{$article->title}\" has been marked as rejected.");
    }

    public function unpublishArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->status = Article::STATUS_DRAFT;
        $article->save();

        return redirect()->back()->with('success', "Article \"{$article->title}\" has been unpublished and moved to Drafts.");
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $user = request()->user();

        if (!$user->isAdmin() && $article->author_id !== $user->ensureAuthorProfile()->id) {
            abort(403, 'You can only delete your own articles.');
        }

        $title = $article->title;
        $article->delete();

        return redirect()->route('dashboard.articles')->with('success', "Article \"{$title}\" deleted successfully!");
    }

    public function adminDeleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $title = $article->title;
        $article->delete();

        return redirect()->back()->with('success', "Article \"{$title}\" deleted successfully.");
    }

    /* ============================================================
     * 3. USER MANAGEMENT (Admin Only)
     * ============================================================ */

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('contact', 'like', "%{$s}%");
            });
        }

        if ($request->filled('role') && $request->input('role') !== 'all') {
            $query->where('user_type', $request->input('role'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $isActive = $request->input('status') === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $totalUsers    = User::count();
        $totalAdmins   = User::where('user_type', 1)->count();
        $totalAuthors  = User::where('user_type', 2)->count();
        $totalRegular  = User::where('user_type', 0)->count();
        $activeUsers   = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        return view('backend.users', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalAuthors',
            'totalRegular',
            'activeUsers',
            'inactiveUsers'
        ));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'contact' => 'nullable|string|max:30',
            'user_type' => 'required|integer|in:0,1,2',
            'is_active' => 'nullable|boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->contact = $validated['contact'] ?? null;
        
        // Prevent changing self role/status
        if ($user->id !== auth()->id()) {
            $user->user_type = $validated['user_type'];
            if (isset($validated['is_active'])) {
                $user->is_active = (bool) $validated['is_active'];
            }
        }

        $user->save();

        if ($user->user_type == 2) {
            $user->ensureAuthorProfile();
        }

        return redirect()->route('dashboard.users')->with('success', "User \"{$user->name}\" updated successfully.");
    }

    public function updateUserType(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard.users')->with('error', 'You cannot change your own role.');
        }

        $validated = $request->validate([
            'user_type' => 'required|integer|in:0,1,2',
        ]);

        $user->user_type = $validated['user_type'];
        $user->save();

        if ($validated['user_type'] == 2) {
            $user->ensureAuthorProfile();
        }

        $roleLabels = [0 => 'Regular User', 1 => 'Admin', 2 => 'Author'];
        $label = $roleLabels[$validated['user_type']] ?? 'Unknown';

        return redirect()->route('dashboard.users')->with('success', "{$user->name}'s role updated to {$label}.");
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard.users')->with('error', 'You cannot deactivate your own account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('dashboard.users')->with('success', "User \"{$user->name}\" has been {$statusText}.");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard.users')->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('dashboard.users')->with('success', "User \"{$name}\" has been deleted.");
    }

    /* ============================================================
     * 4. AUTHOR MANAGEMENT (Admin Only Dedicated Section)
     * ============================================================ */

    public function authors(Request $request)
    {
        $query = Author::with(['user'])->withCount([
            'articles as total_posts',
            'articles as published_posts' => fn($q) => $q->where('status', Article::STATUS_APPROVED),
            'articles as draft_posts' => fn($q) => $q->where('status', Article::STATUS_DRAFT),
            'articles as pending_posts' => fn($q) => $q->where('status', Article::STATUS_PENDING),
        ]);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('specialty', 'like', "%{$s}%")
                  ->orWhere('bio', 'like', "%{$s}%")
                  ->orWhereHas('user', function($qu) use ($s) {
                      $qu->where('email', 'like', "%{$s}%");
                  });
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $isActive = $request->input('status') === 'active';
            $query->where('is_active', $isActive);
        }

        $authors = $query->latest()->paginate(12)->withQueryString();

        $totalAuthors  = Author::count();
        $activeAuthors = Author::where('is_active', true)->count();
        $inactiveAuthors = Author::where('is_active', false)->count();

        return view('backend.authors', compact(
            'authors',
            'totalAuthors',
            'activeAuthors',
            'inactiveAuthors'
        ));
    }

    public function storeAuthor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'specialty' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:200',
            'bio' => 'nullable|string|max:1000',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
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
            'twitter' => $validated['twitter'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'website' => $validated['website'] ?? null,
            'is_active' => true,
            'followers_count' => rand(15, 80),
            'following_count' => rand(5, 30),
        ]);

        return redirect()->back()->with('success', 'New Author added successfully!');
    }

    public function updateAuthor(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'specialty' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:200',
            'bio' => 'nullable|string|max:1000',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
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
            'twitter' => $validated['twitter'] ?? $author->twitter,
            'linkedin' => $validated['linkedin'] ?? $author->linkedin,
            'github' => $validated['github'] ?? $author->github,
            'website' => $validated['website'] ?? $author->website,
        ]);

        return redirect()->back()->with('success', "Author \"{$author->name}\" updated successfully!");
    }

    public function toggleAuthorStatus($id)
    {
        $author = Author::findOrFail($id);
        $author->is_active = !$author->is_active;
        $author->save();

        if ($author->user) {
            $author->user->is_active = $author->is_active;
            $author->user->save();
        }

        $statusText = $author->is_active ? 'activated' : 'deactivated';
        return redirect()->route('dashboard.authors')->with('success', "Author \"{$author->name}\" has been {$statusText}.");
    }

    public function deleteAuthor($id)
    {
        $author = Author::findOrFail($id);
        $name = $author->name;
        $author->delete();

        return redirect()->back()->with('success', "Author \"{$name}\" deleted successfully!");
    }

    /* ============================================================
     * 5. CATEGORY MANAGEMENT (Admin Only Dedicated Section)
     * ============================================================ */

    public function categories(Request $request)
    {
        $query = Category::withCount(['articles as total_posts', 'articles as published_posts' => fn($q) => $q->where('status', Article::STATUS_APPROVED)]);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where('name', 'like', "%{$s}%")->orWhere('description', 'like', "%{$s}%");
        }

        $categories = $query->orderBy('name')->paginate(15)->withQueryString();
        $totalCategories = Category::count();
        $totalCategorizedPosts = Article::whereNotNull('category_id')->count();

        return view('backend.categories', compact('categories', 'totalCategories', 'totalCategorizedPosts'));
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

        return redirect()->back()->with('success', 'New Category added successfully!');
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

        return redirect()->back()->with('success', "Category \"{$category->name}\" updated successfully!");
    }

    public function deleteCategory($id)
    {
        $category = Category::withCount('articles')->findOrFail($id);
        $name = $category->name;
        $category->delete();

        return redirect()->back()->with('success', "Category \"{$name}\" deleted successfully!");
    }

    /* ============================================================
     * 6. COMMENTS MANAGEMENT (Author own posts, Admin all)
     * ============================================================ */

    public function comments(Request $request)
    {
        $user = $request->user() ?: auth()->user();
        $query = Comment::with(['article.author', 'user']);

        // Author can only see comments on their own articles
        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            $query->whereHas('article', function($q) use ($author) {
                $q->where('author_id', $author->id);
            });
        }

        $baseQuery = clone $query;
        $totalComments   = (clone $baseQuery)->count();
        $pendingComments = (clone $baseQuery)->where('is_approved', false)->count();
        $approvedComments = (clone $baseQuery)->where('is_approved', true)->count();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('user_name', 'like', "%{$s}%")
                  ->orWhere('content', 'like', "%{$s}%")
                  ->orWhereHas('article', function($qa) use ($s) {
                      $qa->where('title', 'like', "%{$s}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $st = $request->input('status');
            if ($st === 'pending') {
                $query->where('is_approved', false);
            } elseif ($st === 'approved') {
                $query->where('is_approved', true);
            }
        }

        $comments = $query->latest()->paginate(20)->withQueryString();

        return view('backend.comments', compact('comments', 'totalComments', 'pendingComments', 'approvedComments'));
    }

    public function approveComment(Request $request, $id)
    {
        $user = $request->user();
        $comment = Comment::with('article')->findOrFail($id);

        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            if (!$comment->article || $comment->article->author_id !== $author->id) {
                abort(403, 'Unauthorized. You can only moderate comments on your own articles.');
            }
        }

        $comment->is_approved = true;
        $comment->save();

        return redirect()->back()->with('success', "Comment approved and is now visible on the article!");
    }

    public function hideComment(Request $request, $id)
    {
        $user = $request->user();
        $comment = Comment::with('article')->findOrFail($id);

        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            if (!$comment->article || $comment->article->author_id !== $author->id) {
                abort(403, 'Unauthorized. You can only moderate comments on your own articles.');
            }
        }

        $comment->is_approved = false;
        $comment->save();

        return redirect()->back()->with('success', "Comment has been hidden.");
    }

    public function deleteComment($id)
    {
        $user = request()->user();
        $comment = Comment::with('article')->findOrFail($id);

        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            if (!$comment->article || $comment->article->author_id !== $author->id) {
                abort(403, 'Unauthorized. You can only delete comments on your own articles.');
            }
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    /* ============================================================
     * 7. REPORTS & ANALYTICS (Admin Platform / Author Content)
     * ============================================================ */

    public function charts()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // ADMIN PLATFORM ANALYTICS
            $categories = Category::withCount('articles')->get();
            $categoryNames = $categories->pluck('name');
            $categoryCounts = $categories->pluck('articles_count');

            $topArticles = Article::with(['category', 'author'])
                ->orderBy('views_count', 'desc')
                ->take(6)
                ->get();

            $topAuthors = Author::withCount(['articles as total_articles', 'articles as approved_articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])
                ->withSum('articles', 'views_count')
                ->orderBy('articles_sum_views_count', 'desc')
                ->take(6)
                ->get();

            $totalViews = Article::sum('views_count');
            $totalLikes = Article::sum('likes_count');
            $totalComments = Comment::count();
            $totalPosts = Article::count();

            // Monthly post creation stats for the past 6 months
            $monthlyPosts = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthName = $month->format('M Y');
                $count = Article::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                $monthlyPosts[$monthName] = $count;
            }

            return view('backend.charts', compact(
                'categoryNames',
                'categoryCounts',
                'topArticles',
                'topAuthors',
                'totalViews',
                'totalLikes',
                'totalComments',
                'totalPosts',
                'monthlyPosts'
            ));
        } else {
            // AUTHOR OWN ANALYTICS
            $author = $user->ensureAuthorProfile();
            $authorArticles = Article::where('author_id', $author->id);

            $totalViews = (clone $authorArticles)->sum('views_count');
            $totalLikes = (clone $authorArticles)->sum('likes_count');
            $totalPosts = (clone $authorArticles)->count();
            $publishedPosts = (clone $authorArticles)->approved()->count();

            $totalComments = Comment::whereHas('article', fn($q) => $q->where('author_id', $author->id))->count();

            $topArticles = (clone $authorArticles)->with('category')
                ->orderBy('views_count', 'desc')
                ->take(6)
                ->get();

            // Category breakdown for this author
            $categories = Category::whereHas('articles', fn($q) => $q->where('author_id', $author->id))
                ->withCount(['articles' => fn($q) => $q->where('author_id', $author->id)])
                ->get();
            $categoryNames = $categories->pluck('name');
            $categoryCounts = $categories->pluck('articles_count');

            // Monthly views simulation/calculation
            $monthlyViews = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthName = $month->format('M Y');
                $monthlyViews[$monthName] = (clone $authorArticles)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('views_count');
            }

            return view('backend.charts', compact(
                'totalViews',
                'totalLikes',
                'totalComments',
                'totalPosts',
                'publishedPosts',
                'topArticles',
                'categoryNames',
                'categoryCounts',
                'monthlyViews'
            ));
        }
    }

    /* ============================================================
     * 8. PROFILE & ACCOUNT (Admin & Author)
     * ============================================================ */

    public function account()
    {
        $user = auth()->user();
        $author = $user->ensureAuthorProfile();
        return view('backend.account', compact('user', 'author'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $author = $user->ensureAuthorProfile();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:30',
            'about' => 'nullable|string|max:1000',
            'specialty' => 'nullable|string|max:150',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
        ];

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->contact = $validated['contact'] ?? $user->contact;
        $user->about = $validated['about'] ?? $user->about;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->image = $path;
            if ($author) {
                $author->avatar = asset('storage/' . $path);
            }
        }

        $user->save();

        if ($author) {
            $author->name = $validated['name'];
            $author->bio = $validated['about'] ?? $author->bio;
            if (!empty($validated['specialty'])) {
                $author->specialty = $validated['specialty'];
            }
            $author->twitter = $validated['twitter'] ?? $author->twitter;
            $author->linkedin = $validated['linkedin'] ?? $author->linkedin;
            $author->github = $validated['github'] ?? $author->github;
            $author->website = $validated['website'] ?? $author->website;
            $author->save();
        }

        return redirect()->route('dashboard.account')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->route('dashboard.account')->with('error', 'Current password does not match.');
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('dashboard.account')->with('success', 'Password changed successfully!');
    }

    public function updateNotificationPreferences(Request $request)
    {
        $user = auth()->user();
        $prefs = [
            'email_new_comment' => $request->boolean('email_new_comment'),
            'email_article_status' => $request->boolean('email_article_status'),
            'email_weekly_digest' => $request->boolean('email_weekly_digest'),
            'email_platform_updates' => $request->boolean('email_platform_updates'),
        ];
        $user->notification_preferences = $prefs;
        $user->save();

        return redirect()->route('dashboard.account')->with('success', 'Notification preferences updated successfully!');
    }

    /* ============================================================
     * 9. PLATFORM SETTINGS (Admin Only)
     * ============================================================ */

    public function settings()
    {
        $settings = Setting::getAllKeyValues();
        return view('backend.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $tab = $request->input('setting_tab', 'all');

        if ($tab === 'general' || $tab === 'all') {
            $validated = $request->validate([
                'site_name' => 'required|string|max:100',
                'site_description' => 'nullable|string|max:1000',
                'contact_email' => 'required|email|max:150',
                'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
                'site_favicon' => 'nullable|mimes:jpeg,png,jpg,webp,svg,ico|max:1024',
            ]);

            Setting::set('site_name', $validated['site_name'], 'general', 'string');
            Setting::set('site_description', $validated['site_description'] ?? '', 'general', 'text');
            Setting::set('contact_email', $validated['contact_email'], 'general', 'string');

            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('settings', 'public');
                Setting::set('site_logo', $logoPath, 'general', 'image');
            } elseif ($request->boolean('remove_site_logo')) {
                Setting::set('site_logo', null, 'general', 'image');
            }

            if ($request->hasFile('site_favicon')) {
                $faviconPath = $request->file('site_favicon')->store('settings', 'public');
                Setting::set('site_favicon', $faviconPath, 'general', 'image');
            } elseif ($request->boolean('remove_site_favicon')) {
                Setting::set('site_favicon', null, 'general', 'image');
            }

            // Keep HomeSetting in sync
            try {
                $hs = HomeSetting::first();
                if ($hs) {
                    $hs->site_name = $validated['site_name'];
                    $hs->site_description = $validated['site_description'] ?? $hs->site_description;
                    $hs->save();
                }
            } catch (\Throwable $e) {}
        }

        if ($tab === 'appearance' || $tab === 'all') {
            $validated = $request->validate([
                'theme_mode' => 'required|string|in:light,dark,system',
                'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
                'site_tagline' => 'nullable|string|max:255',
                'posts_per_page' => 'required|integer|min:1|max:50',
            ]);

            Setting::set('theme_mode', $validated['theme_mode'], 'appearance', 'string');
            Setting::set('primary_color', $validated['primary_color'], 'appearance', 'string');
            Setting::set('site_tagline', $validated['site_tagline'] ?? '', 'appearance', 'string');
            Setting::set('posts_per_page', (string) $validated['posts_per_page'], 'appearance', 'integer');
        }

        if ($tab === 'access' || $tab === 'all') {
            $validated = $request->validate([
                'default_user_role' => 'required|string|in:author,reader',
            ]);

            Setting::set('enable_public_registration', $request->boolean('enable_public_registration'), 'access', 'boolean');
            Setting::set('require_author_approval', $request->boolean('require_author_approval'), 'access', 'boolean');
            Setting::set('default_user_role', $validated['default_user_role'], 'access', 'string');

            try {
                $hs = HomeSetting::first();
                if ($hs) {
                    $hs->allow_author_registration = $request->boolean('enable_public_registration');
                    $hs->save();
                }
            } catch (\Throwable $e) {}
        }

        if ($tab === 'comments' || $tab === 'all') {
            Setting::set('enable_comments', $request->boolean('enable_comments'), 'comments', 'boolean');
            Setting::set('require_auth_comments', $request->boolean('require_auth_comments'), 'comments', 'boolean');
            Setting::set('enable_comment_moderation', $request->boolean('enable_comment_moderation'), 'comments', 'boolean');
            Setting::set('enable_comment_replies', $request->boolean('enable_comment_replies'), 'comments', 'boolean');

            try {
                $hs = HomeSetting::first();
                if ($hs) {
                    $hs->auto_approve_comments = !$request->boolean('enable_comment_moderation');
                    $hs->save();
                }
            } catch (\Throwable $e) {}
        }

        if ($tab === 'notifications' || $tab === 'all') {
            Setting::set('enable_email_notifications', $request->boolean('enable_email_notifications'), 'notifications', 'boolean');
            Setting::set('notify_on_new_comment', $request->boolean('notify_on_new_comment'), 'notifications', 'boolean');
            Setting::set('notify_on_new_user', $request->boolean('notify_on_new_user'), 'notifications', 'boolean');
        }

        if ($tab === 'social' || $tab === 'all') {
            $validated = $request->validate([
                'social_github' => 'nullable|url|max:255',
                'social_linkedin' => 'nullable|url|max:255',
                'social_instagram' => 'nullable|url|max:255',
                'social_twitter' => 'nullable|url|max:255',
                'social_youtube' => 'nullable|url|max:255',
                'social_facebook' => 'nullable|url|max:255',
            ]);

            Setting::set('social_github', $validated['social_github'] ?? '', 'social', 'string');
            Setting::set('social_linkedin', $validated['social_linkedin'] ?? '', 'social', 'string');
            Setting::set('social_instagram', $validated['social_instagram'] ?? '', 'social', 'string');
            Setting::set('social_twitter', $validated['social_twitter'] ?? '', 'social', 'string');
            Setting::set('social_youtube', $validated['social_youtube'] ?? '', 'social', 'string');
            Setting::set('social_facebook', $validated['social_facebook'] ?? '', 'social', 'string');
        }

        \Illuminate\Support\Facades\Cache::forget('bloghub_settings_map');

        $tabMessages = [
            'general' => 'General settings updated successfully!',
            'appearance' => 'Appearance and branding settings saved successfully!',
            'access' => 'User & Access settings updated successfully!',
            'comments' => 'Comment system configuration saved successfully!',
            'notifications' => 'Notification preferences saved successfully!',
            'social' => 'Social media links updated successfully!',
            'all' => 'All platform settings have been updated successfully!',
        ];

        $msg = $tabMessages[$tab] ?? 'Platform settings saved successfully!';
        $redirectUrl = route('dashboard.settings') . ($tab !== 'all' ? '#' . $tab : '');

        return redirect($redirectUrl)->with('success', $msg);
    }

    /* ============================================================
     * 10. NOTIFICATIONS & WEBSITE PORTIONS (Existing features)
     * ============================================================ */

    public function notifications()
    {
        $user = request()->user();
        $messages = ContactMessage::latest()->take(10)->get();
        $subscribers = Subscriber::latest()->take(10)->get();
        $pendingArticles = Article::pending()->with(['author', 'category'])->latest()->get();

        $commentsQuery = Comment::with(['article', 'user']);
        if (!$user->isAdmin()) {
            $author = $user->ensureAuthorProfile();
            $commentsQuery->whereHas('article', function($q) use ($author) {
                $q->where('author_id', $author->id);
            });
        }
        $comments = $commentsQuery->latest()->take(10)->get();

        return view('backend.notifications', compact('messages', 'comments', 'subscribers', 'pendingArticles'));
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
            'site_name' => 'BlogHub',
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
        $trendingArticles = Article::with(['category', 'author'])->where('is_trending', true)->get();
        $categories = Category::withCount('articles')->latest()->get();
        $latestArticles = Article::with(['category', 'author'])->latest()->take(12)->get();
        $featuredAuthors = Author::withCount('articles')->latest()->get();

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

        return redirect()->back()->with('success', $message);
    }
}
