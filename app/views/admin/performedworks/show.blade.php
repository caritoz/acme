@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('performedworks-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">&nbsp;</div><!-- /.box-header -->
            <div class="box-body">
                <div class="margin">
                    <div class="btn-group">{{ link_to_route('admin.performedworks.index', 'Volver al Listado', '', array('class' => 'btn btn-default btn-sm')) }}</div>
                    <div class="btn-group">{{ link_to_route('admin.performedworks.edit', 'Editar', array($performedwork->id), array('class' => 'btn btn-info btn-sm')) }}</div>
                    <div class="btn-group">{{ Form::open(array('method' => 'DELETE', 'route' => array('admin.performedworks.destroy', $performedwork->id))) }}{{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}{{ Form::close() }}</div>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">{{{ $performedwork->caption }}}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <blockquote>
                    <p>{{{ $performedwork->summary }}}</p>
                    <small> <cite title="Source Title">{{{ \Carbon\Carbon::parse($performedwork->work_date)->format('F j, Y') }}}</cite></small>
                </blockquote>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@stop