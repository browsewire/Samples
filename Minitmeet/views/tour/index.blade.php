@extends('layout/main')
@section('meta')
<?php  
    foreach($seo as $value){
?>
<title>{{$value->title}}</title>
<meta name="description" content="{{$value->description}}">
<meta name="keywords" content="{{$value->keyword}}">
<?php   } 
      
 ?>
@endsection
@section('tour')
<style type="text/css">
body  {overflow-x: hidden;}

img-:first-child{
	display:none;	
}
</style>
<div id="tourwrapper">
    <div id="test" class="container_24 desktop">{{ HTML::image('img/tour_featured.jpg', 'Overview', array('class' => 'featt')) }}</div>
<div id="tourback">
<div class="tourspacer container_24">
    <div id="txtlink" class="grid_7 bggreen tournav steinem">
        <ul class="tournavul">
         <?php $i=1; foreach($link as $value){
			 $pagename = $value->pagename;
			 $url= DB::table('tour_seo')->where('pagename',$pagename)->lists('url');  
			  $pagename1=$pagename;			 
			 if($pagename=='pdf'){
				 $pagename1="PDF REPORT";
				 }
				 elseif($pagename=='contacts'){					 
					  $pagename1="contact list";
					 }?>
               <li id="submenu-<?php echo $i; ?>" class="submenu"><a onclick ="Addclass(this.value);"  href= "{{URL::to('/tour')}}/{{$url[0]}}">{{strtoupper($pagename1)}}</a></li>
                     <?php 
                     $i++;
		                   } 
		                 ?>
        </ul>
        <div>{{ HTML::link('/register', 'FREE SIGNUP',array('class'=>'button_medium')) }}</div>
    </div><!-- .tournav -->
    <div class="tourtext grid_6">
     
        <div class="headingdiv"><span class="heading darkgreen">{{$title[0]->title}}</span></div>
        <div class="clear"></div>
        
        @foreach($data as $value)        
        
        <p>{{$value->content}}</p>
        <div class="clear"></div>
        @endforeach
    </div><!-- .tourtext -->
    <div  class="slider grid_6">
    
     <img class="slide1"  alt="Overview" src="{{URL::to('/uploads')}}/{{$first_image->image}}">
         <?php  $i=2;  foreach($image as $value ){		  
						 $path= $value->image;
						?>  
      <img class="slide{{$i++}} hidden"  alt="Overview" src="{{URL::to('/uploads')}}/{{$path}}">
      <?php }
      ?>        
        <div><ul id="myid"><li class="active" id="0">&nbsp;</li>
        <?php $k=1; foreach($image as $value){?>
        <li  id="{{$k++}}">&nbsp;</li>
        <?php }?>
        
        </ul></div>
    </div>
  </div>	<!--.tourspacer-->
</div>
</div>
@endsection

@section('tour_mob')
<div id="tourwrapper_mob" class="mobile">

<div class="tourspacer container_24">
    <div class="heading_mob"><h2>{{$title[0]->title}}</h2></div>
    
    <div class="slider_mob">
    
    </div>
    
    <div class="tourtext_mob">
        <div class="clear"></div>
        @foreach($data as $value)
      
        {{$value->content}}
        <div class="clear"></div>
        @endforeach
    </div><!-- .tourtext -->

        <div>
        <ul class="tournavul_mob">
            <li> < </li>
           <?php $i=1;$k=1; foreach($link as $value){
			 $pagename = $value->pagename;
			 $url= DB::table('tour_seo')->where('pagename',$pagename)->lists('url');  
			  $pagename1=$pagename;			 
			 if($pagename=='pdf'){
				 $pagename1="PDF REPORT";
				 }
				 elseif($pagename=='contacts'){					 
					  $pagename1="contact list";
					 }?>
               <li id="submenu-<?php echo $i; ?>" class="submenu"><a onclick ="Addclass(this.value);"  href= "{{URL::to('/tour')}}/{{$url[0]}}">{{$k++}}</a></li>
                     <?php 
                     $i++;
		                   } 
		                 ?>
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
           <?php $i=1; foreach($link as $value){
			 $pagename = $value->pagename;
			 $url= DB::table('tour_seo')->where('pagename',$pagename)->lists('url');  
			  $pagename1=$pagename;			 
			 if($pagename=='pdf'){
				 $pagename1="PDF REPORT";
				 }
				 elseif($pagename=='contacts'){					 
					  $pagename1="contact list";
					 }?>
               <li id="submenu-<?php echo $i; ?>" class="submenu"><a onclick ="Addclass(this.value);"  href= "{{URL::to('/tour')}}/{{$url[0]}}">{{strtoupper($pagename1)}}</a></li>
                     <?php 
                     $i++;
		                   } 
		                 ?>
        </ul>
        <div>{{ HTML::link('/register', 'FREE SIGNUP',array('class'=>'button_medium')) }}</div>
    </div><!-- .tournav -->
    
    
     <div class="tourtext grid_6">
     
        <div class="headingdiv"><span class="heading darkgreen">{{$title[0]->title}}</span></div>
        <div class="clear"></div>
        
        @foreach($data as $value)     
        
        
        <p>{{$value->content}}</p>
        <div class="clear"></div>
        @endforeach
    </div>
    
    
   <!-- .tourtext -->
    <div class="slider_mob">
                                    </div>
</div><!--.tourspacer-->
</div>
</div>
@endsection




