<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->where('is_active', true)
            ->get();
        return response()->json($articles);
    }
    public function show(int $id)
    {
        $article = Article::query()
            ->where('is_active', true)
            ->findOrFail($id);
        return response()->json($article);
    }
}
