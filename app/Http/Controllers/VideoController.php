<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request) {
        $videos = $request->user()->videos()->latestFirst()->get();
        return view('video.index', [
            'videos' => $videos,
        ]);
    }

    public function update(VideoUpdateRequest $request, Video $video) {
        $this->authorize('update', $video);

        $video->update([
           'title' => $request->title,
           'description' => $request->description,
           'access' => $request->access,
            'likes' => $request->has('likes'),
            'comments' => $request->has('comments'),
        ]);

        if ($request->ajax()) {
            return response()->json(null, 200);
        }

        return redirect()->back();
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
               'uid' => $uid
           ]
        ]);

    }
}
