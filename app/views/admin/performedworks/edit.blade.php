@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('performedworks-child') )
@section('content')
@include('admin.partials.notifications')
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Editar Proyecto</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {{ Form::model($performedwork, array('method' => 'PATCH', 'class'=>'firstFrm', 'route' => array('admin.performedworks.update', $performedwork->id))) }}
            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('caption', 'Titulo') }}
                    {{ Form::text('caption', $performedwork->caption, array('class' => 'form-control', 'placeholder' => 'Titulo')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('summary', 'Summary') }}
                    {{ Form::textarea('summary', $performedwork->summary, array('class' => 'form-control', 'placeholder' => 'Summary', 'rows' => '3')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('description', 'Description') }}
                    {{ Form::textarea('description', $performedwork->description, array('class' => 'form-control wysihtml5', 'placeholder' => 'Description', 'rows' => '10')) }}
                </div>

                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                    <label>Work date</label>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker_work_date'>
                            {{ Form::text('work_date', \Carbon\Carbon::parse($performedwork->work_date)->format('Y/m/d'), array('id' =>'work_date', 'class' => 'form-control', 'data-date-format' => 'YYYY/MM/DD')) }}
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
                        </div>
                    </div>
                </div><!-- /.form group -->

                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('published', '1', $performedwork->published) }} Publicar
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('featured', '1', $performedwork->isFeatured()) }} Destacado
                    </label>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
                {{ link_to_route('admin.performedworks.show', 'Cancel', $performedwork->id, array('class' => 'btn')) }}
            </div>
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
@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
@stop