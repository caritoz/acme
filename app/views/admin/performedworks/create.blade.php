@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('performedworks-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6    ">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Agregar Proyecto</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('route' => 'admin.performedworks.store')) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('caption', 'Titulo') }}
                    {{ Form::text('caption', '', array('class' => 'form-control', 'placeholder' => 'Titulo')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('summary', 'Summary') }}
                    {{ Form::textarea('summary', '', array('class' => 'form-control', 'placeholder' => 'Summary', 'rows' => '3')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description', 'Description') }}
                    {{ Form::textarea('description', '', array('class' => 'form-control wysihtml5', 'placeholder' => 'Description', 'rows' => '10')) }}
                </div>
                <!-- Date dd/mm/yyyy -->
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                    <label>Work date</label>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker_work_date'>
                            {{ Form::text('work_date', '', array('id' =>'work_date', 'class' => 'form-control', 'data-date-format' => 'YYYY/MM/DD')) }}
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
                        </div>
                    </div>
                </div><!-- /.form group -->

                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('published') }} Publicar
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('featured') }} Destacado
                    </label>
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