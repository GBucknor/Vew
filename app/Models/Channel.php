<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'avatar_filename'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the slug of the channel.
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Specifies the cardinality between one channel and many videos.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function getImage() {
        if (!$this->avatar_filename) {
            return config('vew.buckets.images') . '/profile/default.png';
        }
        return config('vew.buckets.images') . '/profile' . $this->avatar_filname;
    }
}
