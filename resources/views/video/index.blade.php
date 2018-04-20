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
                                            <a href="/videos/{{ $video->uid }}">
                                                <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} thumbnail" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="text-muted">
                                                        @if(!$video->processed)
                                                            Processing {{ $video->processedPercentage() ? $video->processedPercentage . '%' : 'Starting processing' }}

                                                        @else
                                                            <span>Created at {{ $video->created_at->toDateTimeString() }}</span>
                                                        @endif
                                                    </p>
                                                    <form action="" method="post">
                                                        <a href="/videos/{{ $video->uid }}/edit" class="btn btn-outline-secondary">Edit video</a>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>{{ ucfirst($video->access) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $videos->links() }}
                            @else
                                <p>You have no videos. Would you like to upload one? <a href="{{ url('/upload') }}">Upload</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection