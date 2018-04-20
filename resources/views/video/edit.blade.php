@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Video "{{ $video->title }}"</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="/videos/{{ $video->uid }}" method="post">
                            <div class="form-group{{ $errors->has('title') ? ' has error ' : '' }}">
                                <label for="title">Video Title</label>
                                <input name="title" id="title" class="form-control" type="text" value="{{ old('title') ? old('title') : $video->title }}">

                                @if($errors->has('title'))
                                    <div class="form-text">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has error ' : '' }}">
                                <label for="description">Video Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $video->description }}</textarea>

                                @if($errors->has('description'))
                                    <div class="form-text">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif

                            </div>

                            <div class="form-group{{ $errors->has('access') ? ' has error ' : '' }}">
                                <label for="access">Access Level</label>
                                <select name="access" id="access" class="form-control">
                                    @foreach(['published', 'unlisted', 'private'] as $access)
                                        <option value="{{ $access }}"{{ $video->access == $access ? ' selected="selected"' : ''}}>{{ ucfirst($access) }}</option>
                                    @endforeach
                                </select>

                                @if($errors->has('access'))
                                    <div class="form-text">
                                        {{ $errors->first('access') }}
                                    </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="likes">
                                    <input type="checkbox" name="likes" id="likes"{{ $video->likesAllowed() ? ' checked="checked"' : '' }}> Allow likes and dislikes?
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="comments">
                                    <input type="checkbox" name="comments" id="comments"{{ $video->commentsAllowed() ? ' checked="checked"' : '' }}> Allow comments?
                                </label>
                            </div>

                            <button type="submit" class="btn btn-outline-secondary">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection