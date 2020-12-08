<div class="col-md-4" style="width:98%;">
	<div class="thumbnail">
		<img src="{{{ URL::to('pictures/' . $picture->id . '/show/cache' ) }}}" alt=""/>
		<div class="caption">
			<h3>{{$picture->caption}}</h3>
			<p><span style="font-size:20px;font-weight:bold;text-align:left;">{{$picture->order_picture}}</span></p>
		</div>
	</div>
</div>