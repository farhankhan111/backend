<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentModeratedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderby('created_at')->cursorPaginate(2);

        return CommentResource::collection($comments);
    }

    public function moderate(Request $request, Comment $comment)
    {
        $comment->update(['moderate' => 1]);

       // try {
            $comment->user->notify(new CommentModeratedNotification());
       // } catch (\Exception $e) {
           // return $e->getMessage();
       // }

        return new ApiSuccessResponse($comment,['message' => 'moderated'],200);
    }
}
