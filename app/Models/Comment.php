<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Morilog\Jalali\Jalalian;

class Comment extends Model
{
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'parent_id',
        'reply_id',
        'body'
    ];

    public function getCreatedAtAttribute($value)
    {
        return jdate($value)->ago();
    }

    public function editorable(): MorphTo
    {
        return $this->morphTo();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(related: Comment::class, foreignKey: 'parent_id');
    }

    public function repliesForJson(): HasMany
    {
        return $this->hasMany(related: Comment::class, foreignKey: 'parent_id')
            ->select(['id', 'parent_id', 'user_id', 'body', 'like_count', 'unlike_count', 'created_at'])
            ->with(['user:id,name,username,image']);
    }

    public function reactions()
    {
        return $this->hasMany(CommentLike::class);
    }
}
