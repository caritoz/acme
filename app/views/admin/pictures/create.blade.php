@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('picture-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Agregar Imagen</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('route' => 'admin.pictures.store','files' => true)) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::text('caption', '', array('class' => 'form-control', 'placeholder' => 'Titulo')) }}
                </div>
                <div class="form-group">
                    {{ Form::textarea('short_desc', '', array('class' => 'form-control', 'placeholder' => 'Short Description', 'rows' => '3')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('number', 'Slider') }}
                    {{ Form::select('album_id', $albums, null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Select image</label>
                    {{ Form::file('photo') }}
<!--                    <p class="help-block"><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a> </p>-->
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                {{ link_to(URL::previous(), 'Cancel', ['class' => 'btn']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop