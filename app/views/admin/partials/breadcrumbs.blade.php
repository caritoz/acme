@if ($breadcrumbs)
<ol class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
    @if (!$breadcrumb->last)
    <li><a href="{{{ $breadcrumb->url }}}">@if($breadcrumb->title == 'Dashboard')
            <i class="fa fa-dashboard"></i>
            @endif
            {{{ $breadcrumb->title }}}</a></li>
    @else
    <li class="active">@if($breadcrumb->title == 'Dashboard')
        <i class="fa fa-dashboard"></i>
        @endif
        {{{ $breadcrumb->title }}}</li>
    @endif
    @endforeach
</ol>
@endif