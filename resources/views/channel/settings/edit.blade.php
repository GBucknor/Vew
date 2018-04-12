@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $channel->name }} Settings</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="/channel/{{ $channel->slug }}/edit" method="post" enctype="multipart/form-data">
                            <div class="form-group"{{ $errors->has('name' ? ' has error' : '') }}>
                                <label for="name">Username</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $channel->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group"{{ $errors->has('slug' ? ' has error' : '') }}>
                                <label for="slug">Channel URL</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ config('app.url') }}/channel/</span>
                                    </div>
                                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                                </div>
                                @if ($errors->has('slug'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                                @endif
                            </div>

                            <div class="form-group"{{ $errors->has('description' ? ' has error' : '') }}>
                                <label for="description">Channel Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="avatar_image" id="avatar_image" accept="image/x-png" class="custom-file-input">
                                        <label class="custom-file-label" for="avatar_image">Channel Avatar: .png files only</label>
                                    </div>
                                </div>

                                @if ($errors->has('avatar_image'))
                                    <span class="help-block"><strong>{{ $errors->first('avatar_image') }}</strong></span>
                                @endif
                            </div>

                            <button class="btn btn-outline-secondary" type="submit">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
