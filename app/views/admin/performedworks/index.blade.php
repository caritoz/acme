@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('performedworks') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
{{ Form::open(['method'=>'GET']) }}
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-briefcase"></i> Proyectos</h3> <p>{{ link_to_route('admin.performedworks.create', 'Agregar Proyecto', '', array('class' => 'btn')) }}</p>
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
            @if ($performedworks->count())
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead><tr>
                        <th>Caption</th>
                        <th>Summary</th>
                        <th>Work_date</th>
                        <th>Published</th>
                        <th>Featured</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr></thead><tbody>
                    @foreach ($performedworks as $performedwork)
                    <tr>
                        <td>{{ link_to_route('admin.performedworks.show', $performedwork->caption, $performedwork->id, array('class' => '')) }}</td>
                        <td>{{{ $performedwork->summary }}}</td>
                        <td>{{{ $performedwork->work_date }}}</td>
                        <td class="publish_{{$performedwork->id}}">{{ $performedwork->isPublishHTML() }}</td>
                        <td class="feature_{{$performedwork->id}}">{{ $performedwork->isFeaturedHTML() }}</td>
                        <td>{{ link_to_route('admin.performedworks.edit', 'Edit', array($performedwork->id), array('class' => 'btn btn-info')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.performedworks.destroy', $performedwork->id), 'data-method' => 'delete', 'data-confirm' => 'Are you sure you want to delete?')) }}

                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                        <td>@if (count($performedwork->pictures) > 0)
                            {{ link_to_route('admin.performedworks.orders', 'Ordenar Imagenes', array($performedwork->id), array('class' => 'btn btn-info')) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                {{$performedworks->links()}}
            </div>
            @else
            <div class="box-body">
                <div class="callout callout-info">
                    <h4>No hay proyectos</h4>
                    <!--<p>There are no articles</p>-->
                </div>
            </div>
            @endif
        </div><!-- /.box -->
    </div>
</div>
@stop