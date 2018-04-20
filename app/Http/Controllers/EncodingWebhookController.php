<?php

namespace App\Http\Controllers;

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
        $video = $this->getVideoByFileName();
    }

    protected function encodingProgress(Request $request) {
        //
    }

    private function getVideoByFileName()
    {
        //
    }
}
