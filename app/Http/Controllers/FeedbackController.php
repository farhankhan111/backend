<?php
namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\FeedBack;
use App\Models\Log;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');

        $query = FeedBack::with('user')->withCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'upvote');
            },
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'downvote');
            },
        ]);

        if ($keywords) {
            $query->where('title', 'like', "%$keywords%")
                ->orWhere('desc', 'like', "%$keywords%");
        }

        $query->orderby('id','desc');

        $feedBacks = $query->paginate(5);

        return new ApiSuccessResponse($feedBacks);

    }

    public function store(FeedBackRequest $request): mixed
    {
        $feedback = FeedBack::create($request->validated());

        $feedback->logs()->create([
            'type' => 'feedback_created',
            'message' => 'new feedback created',
            'created_by' => Auth('api')->id()
        ]);

        return new ApiSuccessResponse($feedback,[],201);
    }

    public function show($id): mixed
    {
        $feedBack = FeedBack::with([
            'user','comments' => function ($comments) {
                $comments->with('user');
                $comments->moderate();
            }
        ])
        ->withCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'upvote');
            },
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'downvote');
            },
        ])->findOrFail($id);

        return new ApiSuccessResponse($feedBack, ['message' => '']);

    }

    public function getUserFeedbacks(): mixed
    {
        $userFeedbacks = Feedback::with('user')
            ->where('user_id', auth('api')->id())
            ->paginate(10);

        //return response()->json(['feedbacks' => $userFeedbacks]);

        return new ApiSuccessResponse($userFeedbacks);

    }
}
