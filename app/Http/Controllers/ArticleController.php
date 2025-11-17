<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $featuredArticle = Article::latest()->first();
        $sidebarArticles = Article::latest()->skip(1)->take(2)->get();
        $latestArticles = Article::latest()->skip(3)->paginate(2); 

        return view('pages.article.index', compact('featuredArticle', 'sidebarArticles', 'latestArticles'));
    }

    public function show(Article $article)
    {
        // Logika Related Contents (berdasarkan category, kecuali artikel saat ini)
        $relatedArticles = Article::where('category_id', $article->category_id)
                                  ->where('id', '!=', $article->id)
                                  ->limit(3)
                                  ->inRandomOrder()
                                  ->get();
                                  
        // Ambil komentar untuk artikel ini
        $comments = $article->comments()->with('user')->latest()->get();

        return view('pages.article.detail.index', compact('article', 'relatedArticles', 'comments'));
    }
}
