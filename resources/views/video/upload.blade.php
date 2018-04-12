@extends('layouts.app')

@section('content')
    <video-upload></video-upload>
    {{ csrf_field() }}
    {{ method_field('POST') }}
@stop