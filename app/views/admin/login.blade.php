@extends('admin.layouts.default')
@section('content')
<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    {{ Form::open(['route' => "admin.login.post", 'role' => 'form']) }}
    @if ($errors->has('login'))
    <div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
    @endif
        <div class="body bg-gray">
            <div class="form-group">
                {{ Form::text('email', '', array('placeholder' => 'User', 'class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) }}
            </div>
<!--            <div class="form-group">-->
<!--                {{-- Form::checkbox('remember_me', 'value', false) --}} Remember me-->
<!--            </div>-->
        </div>
        <div class="footer">
            {{ Form::submit('Login', array('class' => 'btn bg-olive btn-block')) }}
<!--            <p><a href="#">I forgot my password</a></p>-->
        </div>
    {{ Form::close() }}
</div>
@stop