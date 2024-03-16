<?php
namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\Http\Resources\FeedBackResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\FeedBack;
use App\Services\LogService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }
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

        return FeedBackResource::collection($feedBacks);
    }

    public function store(FeedBackRequest $request): mixed
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('upload'), $fileName);
        }

        $feedback = FeedBack::create($request->validated());

        return new ApiSuccessResponse($feedback,[],201);
    }

    public function show($id): mixed
    {
        $feedBack = FeedBack::with([
            'user',
            'comments' => function ($comments) {
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

        return new FeedBackResource($feedBack);
    }

    public function getUserFeedbacks(): mixed
    {
        $userFeedbacks = Feedback::with('user')
            ->where('user_id', auth('api')->id())
            ->paginate(10);

        return FeedBackResource::collection($userFeedbacks);
    }
}
