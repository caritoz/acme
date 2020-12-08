@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('albums') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{ Form::open(['method'=>'GET']) }}
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-barcode"></i> Albums</h3> <p>{{ link_to_route('admin.albums.create', 'Agregar Album') }}</p>
                <div class="box-tools">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
            {{ Form::close() }}
            @if ($albums->count())
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead><tr>
                        <th>Tipo</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr></thead><tbody>
                    @foreach ($albums as $album)
                    <tr>
                        <td>{{{ $album->caption }}}</td>
                        <td>{{ link_to_route('admin.albums.edit', 'Editar', array($album->id), array('class' => 'btn btn-info btn-sm')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.albums.destroy', $album->id), 'data-method' => 'delete', 'data-confirm' => 'Are you sure you want to delete?')) }}
                            {{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}
                            {{ Form::close() }}
                        </td>
                        <td>@if (count($album->pictures) > 0)
                            {{ link_to_route('admin.albums.orders', 'Ordenar Imagenes', array($album->id), array('class' => 'btn btn-info')) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                {{$albums->links()}}
            </div>
            @else
            <div class="box-body">
                <div class="callout callout-info">
                    <h4>No hay albums</h4>
                    <!--<p>There are no albums</p>-->
                </div>
            </div>
            @endif
        </div><!-- /.box -->
    </div>
</div>
@stop