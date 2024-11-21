<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Вы должны быть авторизованы для создания комментариев.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'content' => $request->content,
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'Комментарий успешно добавлен.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Вы не можете удалить этот комментарий.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий успешно удален.');
    }
}