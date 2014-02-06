@extends('layout/main')

@section('title')
Tour Create Minutes
@endsection

@section('topnav')
    <li>{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
    <li class="home">{{ HTML::linkAction('TourController@index', 'Tour') }}</li>
    <li>{{ HTML::link('/register', 'Sign Up') }}</li>
    <li>{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
@endsection

@section('tour')
<style type="text/css">
body  {overflow-x: hidden;}
</style>
<div id="tourwrapper">
     <div id="test" class="container_24 desktop">{{ HTML::image('img/tour_featured.jpg', 'Overview', array('class' => 'featt')) }}</div>
<div id="tourback">
<div class="tourspacer container_24">
    <div class="grid_7 bggreen tournav steinem">
        <ul class="tournavul">
            <li>{{ HTML::linkAction('TourController@index', 'OVERVIEW') }}</li>
            <li class="active">{{ HTML::linkAction('TourController@create','CREATE MINUTES') }}</li> 
            <li>{{ HTML::linkAction('TourController@pdf','PDF REPORT') }}</li> 
            <li>{{ HTML::linkAction('TourController@contacts','CONTACT LIST') }}</li>
        </ul>
        <div>{{ HTML::link('/register', 'FREE SIGNUP',array('class'=>'button_medium')) }}</div>
    </div><!-- .tournav -->
   <div class="tourtext grid_6">     
        <div class="headingdiv"><span class="heading darkgreen">{{$data[0]->head }}</span></div>
        <div class="clear"></div>        
        @foreach($data as $value)            
        <div class="subheading">{{ $value->subhead}} </div>
        <div class="clear"></div>
        <p>{{$value->descp}}</p>
        <div class="clear"></div>
        @endforeach
    </div><!-- .tourtext -->
    <?php $first_path = $first->path;
           $a= explode('/',$first_path);  
     ?>
     
     
      <div class="slider grid_6"> 
      <img class="slide1" alt="Overview" src="{{URL::to('/uploads')}}/{{$first_path}}" >
         <?php  $i=2;  foreach($image as $value ){
		  
						 $path= $value->path;
						 $exp =explode('/',$path);
						?>  
      <img class="slide{{$i++}} hidden" alt="Overview" src="{{URL::to('/uploads')}}/{{$path}}">
      <?php }
      ?>        
        <div><ul id="myid"><li class="active" id="0">&nbsp;</li> 
        
        <?php $k=1; foreach($image as $value){?>
        <li id="{{$k++}}">&nbsp;</li>
        <?php }?>
        
        </ul></div>
    </div>	
</div><!--.tourspacer-->
</div>
</div>
@endsection
@section('tour_mob')
<div id="tourwrapper_mob" class="mobile">

<div class="tourspacer container_24">
    <div class="heading_mob"><h2>CREATE MINITS</h2></div>    
    <?php $first_path = $first->path;
           $a= explode('/',$first_path);  
     ?>
      <div class="slider_mob">
      <img class="slide1" alt="Overview" src="{{URL::to('/uploads')}}/{{$first_path}}" >
         <?php  $i=2;  foreach($image as $value ){
		  
						 $path= $value->path;
						 $exp =explode('/',$path);
						?>  
      <img class="slide{{$i++}} hidden" alt="Overview" src="{{URL::to('/uploads')}}/{{$path}}">
      <?php }
      ?>        
        
    </div>	
    
    
     <div class="tourtext_mob ">
      <div class="clear"></div>       
        @foreach($data as $value)            
        <div class="subheading">{{ $value->subhead}} </div>
        <div class="clear"></div>
        <p>{{$value->descp}}</p>
        <div class="clear"></div>
        @endforeach
    </div>
    
   <!-- .tourtext -->

        <div>
        <ul class="tournavul_mob">
            <li> < </li>
            <li>{{ HTML::linkAction('TourController@index', '1') }} |</li>
            <li class="active">{{ HTML::linkAction('TourController@create','2') }} |</li> 
            <li>{{ HTML::linkAction('TourController@pdf','3') }} |</li> 
            <li>{{ HTML::linkAction('TourController@contacts','4') }}</li>
            <li> > </li>
        </ul>
    </div><!-- .tournav -->
</div><!--.tourspacer-->

</div>
@endsection
@section('tour_tablet')
<div id="tourwrapper_tablet" class="tablet">
<div id="tourback_tablet">
<div class="tourspacer container_24">
    <div class="grid_7 bggreen tournav steinem">
        <ul class="tournavul">
            <li>{{ HTML::linkAction('TourController@index', 'OVERVIEW') }}</li>
            <li class="active">{{ HTML::linkAction('TourController@create','CREATE MINUTES') }}</li> 
            <li>{{ HTML::linkAction('TourController@pdf','PDF REPORT') }}</li> 
            <li>{{ HTML::linkAction('TourController@contacts','CONTACT LIST') }}</li>
        </ul>
        <div>{{ HTML::link('/register', 'FREE SIGNUP',array('class'=>'button_medium')) }}</div>
    </div><!-- .tournav -->
    <div class="tourtext grid_6">     
        <div class="headingdiv"><span class="heading darkgreen">{{$data[0]->head }}</span></div>
        <div class="clear"></div>        
        @foreach($data as $value)            
        <div class="subheading">{{ $value->subhead}} </div>
        <div class="clear"></div>
        <p>{{$value->descp}}</p>
        <div class="clear"></div>
        @endforeach
    </div><!-- .tourtext -->
    <div class="slider_mob">
                                    </div>
</div><!--.tourspacer-->
</div>
</div>
@endsection
