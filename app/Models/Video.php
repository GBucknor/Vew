<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'video_filename',
        'uid',
        'video_id',
        'processed',
        'access',
        'comments',
        'likes',
        'processed_percent',
    ];

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName() {
        return 'uid';
    }

    public function scopeLatestFirst($query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function isProcessed() {
        return $this->processed;
    }

    public function getThumbnail() {
        if (!$this->isProcessed()) {
            return config('vew.buckets.videos') . '/default.png';
        }

        return config('vew.buckets.videos') . '/' . $this->video_id . '_1.jpg';
    }

    public function processedPercentage() {
        return $this->processed_percent;
    }

    public function likesAllowed() {
        return (bool) $this->likes;
    }

    public function commentsAllowed() {
        return (bool) $this->comments;
    }

    public function isPrivate() {
        return $this->access === 'private';
    }

    public function ownedByUser(User $user) {
        return $this->channel->user->id === $user->id;
    }

    public function accessAllowed(User $user = null) {
        if (!$user && $this->isPrivate())
            return false;

        if ($user && $this->isPrivate() && ($user->id !== $this->channel->user_id))
            return false;

        return true;
    }
}
