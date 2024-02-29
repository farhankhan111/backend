<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Comment;
use App\Notifications\CommentModeratedNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderby('created_at')->cursorPaginate(2);

        return new ApiSuccessResponse($comments);
    }

    public function moderate(Comment $comment)
    {
        $comment->update(['moderate' => 1]);
        $comment->user->notify(new CommentModeratedNotification());

        return new ApiSuccessResponse($comment,['message' => 'moderated'],200);

    }
}
