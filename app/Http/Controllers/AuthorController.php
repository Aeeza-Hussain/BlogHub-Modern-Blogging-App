<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::withCount('articles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
        }

        $authors = $query->paginate(8);
        return view('authors.index', compact('authors'));
    }

    public function show($slug)
    {
        $author = Author::withCount('articles')->where('slug', $slug)->firstOrFail();
        $articles = Article::with(['category', 'author'])
            ->where('author_id', $author->id)
            ->latest()
            ->paginate(6);

        return view('authors.show', compact('author', 'articles'));
    }
}
