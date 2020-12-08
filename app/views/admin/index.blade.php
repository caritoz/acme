@extends('admin.layouts.default')
@section('breadcrumbs', Breadcrumbs::render('admin') )
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
<!-- SLIDERS -->
@include('admin.partials.box-min-dashboard-list', ['sliders' => $sliders])
</div>
@stop