@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('albums-child') )
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Agregar Album</h3>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
                @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('route' => 'admin.albums.store')) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::text('caption', '', array('class' => 'form-control', 'placeholder' => 'Caption')) }}
                </div>
            </div>
            <div class="box-footer">
                {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
                {{ link_to(URL::previous(), 'Cancel', ['class' => 'btn']) }}
            </div><!--/box-footer-->
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop