@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Videos</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($videos->count())
                            @foreach($videos as $video)
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            thumbnail
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    data
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>{{ ucfirst($video->access) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <p>You have no videos. Would you like to upload one? <a href="{{ url('/upload') }}">Upload</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection