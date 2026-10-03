<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        if (!empty($query)) {
            $articles = Article::approved()->with(['category', 'author'])
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('body', 'like', "%{$query}%");
                })
                ->latest('published_at')
                ->paginate(9);
        } else {
            $articles = collect();
        }

        $suggestedCategories = Category::take(6)->get();

        return view('search', compact('query', 'articles', 'suggestedCategories'));
    }
}
