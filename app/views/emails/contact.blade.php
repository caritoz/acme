@extends('frontend.layouts.emails')

@section('title')
{{ $message->getSubject() }}
@stop

@section('body')
<p>From: {{ $nombre }} <{{ $email }}></p>
<p>Time: {{ $now }} </p>
<p></p>
<blockquote>{{{ $body }}}</blockquote>
@stop