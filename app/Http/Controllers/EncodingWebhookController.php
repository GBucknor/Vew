<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class EncodingWebhookController extends Controller
{
    public function handle(Request $request) {
        $event = camel_case($request->event);

        if (method_exists($this, $event)) {
            $this->{$event}($request); // Beautiful
        }
    }

    protected function videoEncoded(Request $request) {
        // Looks up the video in the database
        $video = $this->getVideoByFileName($request->original_filename);
        // Updates processed
        $video->processed = true;
        $video->video_id = $request->encoding_ids[0];

        $video->save();
    }

    protected function encodingProgress(Request $request) {
        $video = $this->getVideoByFileName($request->original_filename);
        $video->processed_percent = $request->progress;
        $video->save();
    }

    private function getVideoByFileName($filename) {
        return Video::where('video_filename', $filename)->firstOrFail();
    }
}
