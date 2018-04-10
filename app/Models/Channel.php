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
}
