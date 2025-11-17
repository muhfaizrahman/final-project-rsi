<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article) {
        $request->validate(['content' => 'required|string|max:500']);
        
        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content')
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function update(Request $request, Comment $comment) {
        $request->validate(['content' => 'required|string|max:1000']);
        $comment->update(['content' => $request->input('content')]);

        return back()->with('success', 'Komentar berhasil diedit.');
    }

    public function delete(Comment $comment) {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
