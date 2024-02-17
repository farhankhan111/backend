<?php

namespace App\Http\Requests;

use App\Models\Vote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::guard('api')->id()
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;
        $itemId = $this->input('feedback_id');
        return [
            'feedback_id' => 'required',
            'vote_type' => [
                'required',
                function ($attribute, $value, $fail) use ($userId, $itemId) {
                $existingVote = Vote::where('user_id', $userId)
                    ->where('feedback_id', $itemId)
                    ->first();

                if ($existingVote) {
                    $fail('User already voted for this item.');
                }
            }],
            'user_id'=>'required|integer'
        ];
    }
}
