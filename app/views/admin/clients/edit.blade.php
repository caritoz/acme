@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('clients') )
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Editar Cliente</h3>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
                @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::model($client, array('method' => 'PATCH', 'route' => array('admin.clients.update', $client->id))) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::text('company_or_name', @$client->company_or_name, ['class'=>'form-control', 'placeholder' => 'Company or Name']) }}
                </div>
                <div class="form-group">
                    {{ Form::text('address', @$client->address, ['class'=>'form-control', 'placeholder' => 'Address']) }}
                </div>
                <div class="form-group">
                    {{ Form::text('phone_1', @$client->phone_1, ['class'=>'form-control', 'placeholder' => 'Phone 1']) }}
                </div>
                <div class="form-group">
                    {{ Form::text('phone_2', @$client->phone_2, ['class'=>'form-control', 'placeholder' => 'Phone 2']) }}
                </div>
                <div class="form-group">
                    {{ Form::text('web', @$client->web, ['class'=>'form-control', 'placeholder' => 'Web']) }}
                </div>
            </div>
            <div class="box-footer">
                {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
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
                @include('admin.layouts.uploads-form')
            </div><!-- /.box-body -->
            <div class="box-footer"></div>
        </div>
    </div>
</div>
@stop