@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 offset-md-1">
                @if($video->isPrivate() && \Illuminate\Support\Facades\Auth::check() && $video->ownedByUser(\Illuminate\Support\Facades\Auth::user()))
                    <div class="alert alert-info">
                        Only you can see this video, as it is set as private.
                    </div>
                @endif

                @if($video->isProcessed() && $video->accessAllowed(\Illuminate\Support\Facades\Auth::user()))
                    <video-player video-uid="{{ $video->uid }}" video-url="{{ $video->getStreamUrl() }}" thumbnail-url="{{ $video->getThumbnail() }}"></video-player>
                @endif

                    @if(!$video->isProcessed())
                        <div class="video-placeholder">
                            <div class="vp-header">
                                Your video is currently processing.
                            </div>
                        </div>
                    @elseif(!$video->accessAllowed(\Illuminate\Support\Facades\Auth::user()))
                        <div class="video-placeholder">
                            <div class="vp-header">
                                This video is private.
                            </div>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $video->title }}</h4>
                        <div class="float-right">
                            View Count
                        </div>

                        <div class="media">
                            <div class="mr-3">
                                <a href="/channel/{{ $video->channel->slug }}">
                                    <img src="{{ $video->channel->getImage() }}" alt="{{ $video->channel->name }} avatar" class="img-thumbnail img-fluid">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="/channel/{{ $video->channel->slug }}" class="mt-0">{{ $video->channel->name }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($video->description)
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($video->description)) !!}
                        </div>
                    </div>
                @endif


                <div class="card">
                    <div class="card-body">
                        @if($video->commentsAllowed())
                            Comments
                        @else
                            <p>The uploader has comments disabled.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection