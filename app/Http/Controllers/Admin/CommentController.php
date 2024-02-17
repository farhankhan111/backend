<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Notifications\CommentModeratedNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderby('created_at')->cursorPaginate(2);
        return response()->json(['comments' => $comments], 200);
    }

    public function moderate(Comment $comment)
    {
        $comment->update(['moderate' => 1]);
        $comment->user->notify(new CommentModeratedNotification());
        return response()->json(['message' => 'moderated'], 200);
    }
}
