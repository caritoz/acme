@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('albums-child') )
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">&nbsp;</div><!-- /.box-header -->
            <div class="box-body">
                <div class="margin">
                    <div class="btn-group">{{ link_to_route('admin.albums.index', 'Volver al Listado', '', array('class' => 'btn btn-default btn-sm')) }}</div>
                    <div class="btn-group">{{ link_to_route('admin.albums.edit', 'Editar', array($album->id), array('class' => 'btn btn-info btn-sm')) }}</div>
                    <div class="btn-group">{{ Form::open(array('method' => 'DELETE', 'route' => array('admin.albums.destroy', $album->id))) }}{{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}{{ Form::close() }}</div>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-text-width"></i>
            </div><!-- /.box-header -->
            <div class="box-body">
                <blockquote>
                    <p>{{{ $album->caption }}}</p>
                    <!--<small>Someone famous in <cite title="Source Title">Source Title</cite></small>-->
                </blockquote>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@stop
