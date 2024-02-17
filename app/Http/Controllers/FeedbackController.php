<?php
namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\Models\FeedBack;
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

        return response()->json(['feedbacks' => $feedBacks]);
    }

    public function store(FeedBackRequest $request)
    {
        $feedback = FeedBack::create($request->validated());

        return response()->json($feedback);
    }

    public function show($id)
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

        return response()->json(['feedback' => $feedBack]);
    }

    public function getUserFeedbacks()
    {
        $userFeedbacks = Feedback::with('user')
            ->where('user_id', auth('api')->id())
            ->paginate(10);

        return response()->json(['feedbacks' => $userFeedbacks]);
    }
}
