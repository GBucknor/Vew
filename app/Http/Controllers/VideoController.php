<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class VideoController extends Controller
{
    public function show(Video $video) {
        return view('video.show', [
            'video' => $video,
        ]);
    }

    public function index(Request $request) {
        $videos = $request->user()->videos()->latestFirst()->get();
        return view('video.index', [
            'videos' => $this->paginate($videos),
        ]);
    }

    public function edit(Video $video) {
        $this->authorize('edit', $video);

        return view('video.edit', [
            'video' => $video,
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

    public function delete(Video $video) {
        $this->authorize('delete', $video);
        $video->delete();
        return redirect()->back();
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
