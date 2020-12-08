@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('picture-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">&nbsp;</div><!-- /.box-header -->
            <div class="box-body">
                <div class="margin">
                    <div class="btn-group">{{ link_to_route('admin.pictures.index', 'Volver al Listado', '', array('class' => 'btn btn-default btn-sm')) }}</div>
                    <div class="btn-group">{{ link_to_route('admin.pictures.edit', 'Editar', array($picture->id), array('class' => 'btn btn-info btn-sm')) }}</div>
                    <div class="btn-group">{{ Form::open(array('method' => 'DELETE', 'route' => array('admin.pictures.destroy', $picture->id))) }}{{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}{{ Form::close() }}</div>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="thumbnail">
                <img src="{{{ URL::to('pictures/' . $picture->id . '/show/mini-carousel' ) }}}" alt=""/>
                <div class="caption">
                    <h3>{{{ $picture->caption }}}</h3>
                    <blockquote>
                        <p>{{ $picture->short_desc }}</p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
@stop