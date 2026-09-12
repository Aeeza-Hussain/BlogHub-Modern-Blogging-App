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
            $articles = Article::with(['category', 'author'])
                ->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->orWhere('body', 'like', "%{$query}%")
                ->paginate(9);
        } else {
            $articles = collect();
        }

        $suggestedCategories = Category::take(6)->get();

        return view('search', compact('query', 'articles', 'suggestedCategories'));
    }
}
