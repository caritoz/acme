@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('albums-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Editar Album</h3>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
                @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::model($album, array('method' => 'PATCH', 'route' => array('admin.albums.update', $album->id))) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::text('caption', $album->caption, array('class' => 'form-control', 'placeholder' => 'Nombre')) }}
                </div>
            </div>
            <div class="box-footer">
                {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
                {{ link_to(URL::previous(), 'Cancel', ['class' => 'btn']) }}
            </div><!--/box-footer-->
            <script type="text/javascript">
                var existingfiles = {{$json}};
            </script>
            {{ Form::close() }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Imagenes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('admin.albums.partials.uploads-form')
            </div><!-- /.box-body -->
            <div class="box-footer"></div>
        </div>
    </div>
</div>
@stop