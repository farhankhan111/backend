<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedBack extends Model
{
    use HasFactory;

    protected $fillable = ['title','desc','type','user_id'];

    public function getTitleAttribute($value): string
    {
        return ucwords($value);

    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class,'feedback_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'feedback_id');

    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

}
