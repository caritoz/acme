<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin | </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ URL::asset('/assets/js/jquery/jquery-ui-1.10.4.custom.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/ionicons.min.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('/assets/css/bootstrap-dialog/bootstrap-dialog.min.css')}}"  type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/fullcalendar/fullcalendar.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('/assets/css/datetimepicker/bootstrap-datetimepicker.min.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('/assets/css/timepicker/bootstrap-timepicker.min.css')}}" />

    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/blueimp/jquery.fileupload.css')}}" />

    <link rel="stylesheet" href="{{ URL::asset('/assets/css/AdminLTE.css')}}" />
<!--    <link rel="stylesheet" href="{{ URL::asset('/assets/css/fullcalendar/fullcalendar.print.css')}}" />-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ URL::asset('/assets/js/html5shiv.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>
@if( Sentry::check() )
<body class="skin-black pace-done fixed">
@else
<body class="bg-black">
@endif
@if( Sentry::check() )
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        @include('admin.layouts.header')
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                @include('admin.layouts.sidebar')
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Dashboard<small>Control panel</small></h1>
                @yield('breadcrumbs')
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="alert-acme"></div>
                @yield('content')
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
</div>
@else
    @yield('content')
@endif
<!-- JS -->

<script src="{{ URL::asset('/assets/js/jquery/jquery-1.10.2.js') }}"></script>
<script src="{{ URL::asset('/assets/js/jquery/jquery-ui-1.10.4.custom.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/plugins/AdminLTE/app.js') }}"></script>
<script src="{{ URL::asset('/assets/js/scripts.js') }}"></script>

@if( Sentry::check() )
    @include('admin.layouts.footer')
@endif
</body>
</html>