@foreach($content as $get)
 	<div class="widget">
		 <div class="widget-body">
			  {{$get['post']}}
			</div>
			<div class="comment_box">
				 &nbsp;&nbsp; <a href="{{URL::to($get['username'])}}" ><img title="" data-toggle="tooltip"src="{{URL::to('img/profile_25')}}/{{$get['profilePic']}}" width="20"  height="20"  /></a>
			</div>
	</div>
@endforeach
<?=$paginationdata->links()?>
