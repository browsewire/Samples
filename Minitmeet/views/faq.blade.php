@extends('layout/main')

@section('title')
FAQ
@endsection

@section('topnav')
    <li>{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
    <li>{{ HTML::linkAction('TourController@index', 'Tour') }}</li>
    <li>{{ HTML::link('/register', 'Sign Up') }}</li>
    <li class="home">{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
@endsection

@section('tour')
<div class="bgsilver clearfix">
<div id="wrapper" class="container_24 bgwhite padding_30 faq  register_wrapper">
<div class="darkgray title fan-top"><h1>Frequently Asked Questions</h1></div>
<div class="bggray padding_20 brsilver_topwhite fan clearfix faq_div">
   	<?php $i=1;$j=1;$k=1;$l=1;$m=1;$n=1; ?>
     		@foreach($data as $value)
     		
    <div class="quest question{{$n++}} grid_13">
  {{ $value->question }}<a href="#<?php echo $j++ ;?>" class="showans">Answer</a>
    </div>
    <div class="clear"></div>
    <div class="ansbg answer{{$k++}} hidden clearfix"><div class="ans grid_12">
          {{ $value->answer }}
        </div><div class="grid_1 closediv close{{$l++}}"><a href="{{$m++}}" class="closeans">&nbsp;</a></div> </div>
    <div class="clear"></div>
        <div class="faq-sep"></div> 		
     		
     		@endforeach


</div>
</div>
</div>
@endsection
@section('call')
<script type="text/javascript">


function faq(){
    /*jQuery().click(function(){});*/
    jQuery('.showans').click(function(e){
        e.preventDefault();
        var id= jQuery(this).attr("href");
        id = id.replace("#","");
        jQuery('.answer'+id).slideDown(function(){
            jQuery('.closeans').unbind('click').click(function(e){
                e.preventDefault();
                var id= jQuery(this).attr("href");
                id = id.replace("#","");
                jQuery('.answer'+id).slideUp();
            });
        });
    });
}
faq();
</script>
@endsection
