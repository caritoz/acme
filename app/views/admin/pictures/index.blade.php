@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('picture'))
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
{{ Form::open(['method'=>'GET']) }}
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-camera"></i> Imagenes</h3> <p>{{ link_to_route('admin.pictures.create', 'Agregar Imagen') }}</p>
                <div class="box-tools">
                    <div class="input-group">
                            {{ Form::input('search', 'q', null, ['placeholder' => 'Search', 'class' => 'form-control input-sm pull-right', 'style'=>'width: 150px;'] ) }}
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                </div>
            </div><!-- /.box-header -->
{{ Form::close() }}
            @if ($pictures->count())
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead><tr>
                        <th>&nbsp;</th>
                        <th>Imagen</th>
                        <th>Album</th>
                        <th>Tipo</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr></thead><tbody>
                    @foreach ($pictures as $picture)
                    <tr>
                        <td><img src="{{{ URL::to('pictures/' . $picture->id . '/show/smallest' ) }}}" alt=""/></td>
                        <td>{{{ $picture->caption }}}</td>
                        <td>{{ $picture->AlbumName() }}</td>
                        <td>{{{ $picture->type_picture }}}</td>
                        <td>{{ link_to_route('admin.pictures.edit', 'Edit', array($picture->id), array('class' => 'btn btn-info btn-sm')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.pictures.destroy', $picture->id), 'data-method' => 'delete', 'data-confirm' => 'Are you sure you want to delete?')) }}
                            {{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                {{$pictures->links()}}
            </div>
            @else
            <div class="box-body">
                <div class="callout callout-info">
                    <h4>No hay imagenes</h4>
                    <!--<p>There are no articles</p>-->
                </div>
            </div>
            @endif
        </div><!-- /.box -->
    </div>
</div>

@stop