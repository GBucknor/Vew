<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    /**
     * Returns the video uploader view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('video.upload');
    }

    public function store(Request $request) {
        // Collects the current user channel
        $channel = $request->user()->channel()->first();

        // Searches for the video in the vew database
        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        // Moves file to a temporary location
        $request->file('video')->move(storage_path() . '/uploads/', $video->video_filename);

        // Uploaded mp4 to Amazon S3
        $this->dispatch(new UploadVideo(
            $video->video_filename
        ));

        return response()->json(null);
    }
}
