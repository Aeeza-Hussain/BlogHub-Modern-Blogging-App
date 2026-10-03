<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', Article::STATUS_APPROVED)])->get();
        return view('categories.index', compact('categories'));
    }
}
