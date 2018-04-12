<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function update(Request $request, Video $video) {
        echo 'update';
    }

    public function store(Request $request) {
        // Generates the video uid
        $uid = uniqid(true);

        // Request channel first
        $channel = $request->user()->channel()->first();

        // Creates the video
        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'access' => $request->access,
            'video_filename' => "{$uid}.{$request->extension}",

        ]);

        return response()->json([
           'data' => [
               'uid' => $uid,
           ]
        ]);

    }
}
