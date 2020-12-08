@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('picture-child') )
@section('content')
@include('admin.partials.notifications')
<style type="text/css">
/* show the move cursor as the user moves the mouse over the panel header.*/
#draggablePanelList{width: 974px;}
#draggablePanelList .thumbnail {cursor: move;}
#draggablePanelList li.list-item {margin: 3px 3px 3px 0;padding: 1px;float: left;width: 316px;height: 264px;}
</style>
<div class="col-md-12 column">
    <div class="row">
        <div class="box box-primary">
            <div class="box-header">
                <!-- tools box -->
                <h3 class="box-title">Listado</h3>
            </div>
            <div class="box-body no-padding"></div><!-- /.box-body-->
            <div class="box-footer">
                <p><a class="btn btn-primary" href="javascript:void(0);" onclick="saveOrder();">Save</a> {{ link_to(URL::previous(), 'Volver', ['class' => 'btn']) }}</p>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row">
                <ul id="draggablePanelList" class="row list-unstyled">
                    @foreach($pictures as $i => $picture)
                    <li class="list-item" data-article-id='{{$picture->id}}'>
                        @include('admin.pictures.partials.picture-list-item', ['picture' => $picture])
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@stop