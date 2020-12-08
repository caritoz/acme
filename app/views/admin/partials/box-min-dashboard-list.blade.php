<div class="col-md-6">
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Carousel</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            @if(count($sliders) > 0)
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($sliders as $key => $picture)
                    <li data-target="#carousel-slider" data-slide-to="{{$key}}" class="<?=($key ==1  ?'active':'');?>"></li>
                    @endforeach
                </ol>

                <div class="carousel-inner">
                    @foreach($sliders as $key => $picture)
                    <div class="item <?=($key ==1  ?'active':'');?>">
                        <img src="{{{ URL::to('pictures/' . $picture->id . '/show/mini-carousel' ) }}}" alt="{{$picture->caption}}"/>
                        <div class="carousel-caption">{{$picture->caption}}</div>
                    </div>
                    @endforeach
                </div>

                <a class="left carousel-control" href="#carousel-slider" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-slider" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
            @endif
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>