@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('clients') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{ Form::open(['method'=>'GET']) }}
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-barcode"></i> Clients</h3> <p>{{ link_to_route('admin.clients.create', 'Agregar Cliente') }}</p>
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
            @if ($clients->count())
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead><tr>
                        <th>Company or name</th>
                        <th>Address</th>
                        <th>Phone 1</th>
                        <th>Phone 2</th>
                        <th>Web</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr></thead><tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ @$client->company_or_name }}</td>
                        <td>{{ @$client->address }}</td>
                        <td>{{ @$client->phone_1 }}</td>
                        <td>{{ @$client->phone_2 }}</td>
                        <td>{{ @$client->web }}</td>
                        <td>{{ link_to_route('admin.clients.edit', 'Editar', array($client->id), array('class' => 'btn btn-info btn-sm')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.clients.destroy', $client->id), 'data-method' => 'delete', 'data-confirm' => 'Are you sure you want to delete?')) }}
                            {{ Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                {{$clients->links()}}
            </div>
            @else
            <div class="box-body">
                <div class="callout callout-info">
                    <h4>No hay clientes</h4>
                </div>
            </div>
            @endif
        </div><!-- /.box -->
    </div>
</div>
@stop