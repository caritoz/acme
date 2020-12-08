<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>Admin | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/AdminLTE.css')}}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">
<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    {{ Form::open(['route' => "admin.auth.login.post", 'role' => 'form']) }}
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
            <div class="form-group">
                {{ Form::checkbox('remember_me', 'value', false) }} Remember me
            </div>
        </div>
        <div class="footer">
            {{ Form::submit('Login', array('class' => 'btn bg-olive btn-block')) }}
            <p><a href="#">I forgot my password</a></p>
        </div>
    {{ Form::close() }}
</div>
<script src="{{ URL::asset('/assets/js/jquery.js') }}"></script>
<script src="{{ URL::asset('/assets/js/bootstrap.min.js') }}"></script>
</body>
</html>