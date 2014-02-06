<!DOCTYPE HTML>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=480px">
<link rel="icon" type="image/png" href="{{URL::to('img/favicon.png') }}">
   @yield('meta')
   <link href="{{URL::to('css/style.css')}}" rel="stylesheet">
      <link href="{{URL::to('css/media.css')}}" rel="stylesheet">
         <link href="{{URL::to('css/check/style.css')}}" rel="stylesheet">
    
   
   @yield('css')
    <!--[if IE]>
<link href="{{ URL::to('css/ie.css') }}" media="all" type="text/css" rel="stylesheet">
<![endif]-->
</head>
<body class="bggreen">
<!-- Forgot password overlay -->
 <form id="recoverpwd" action="{{URL::to('/recoverpwd') }}" method="POST">
 <div class="closeform"></div> 
 <div class="err">This Email address is not found in our database.</div>
 <input type="email" class="emailpwd" required name="email">
 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 <input type="submit" class="submitpwd" name="reset">
 </form>
<div class="pwd_display">
</div>
<!-- END -->
<!-- TERMS OVERLAY -->
<div class="terms_div rterms">
    <div class="closeform termsclose"></div> 
    <div id="conditions">
        {{ View::make('layout.terms') }}
    </div>
</div>
<!-- END TERMS OVERLAY -->
<!-- PRVACY POLICY -->
<div class="terms_div privacy">
    <div class="closeform termsclose"></div> 
    <div id="conditions">
{{ View::make('layout.privacy') }}
    </div>      
</div>
<div class="pwd_display terms-overlay"></div>
<!-- END OF PRVACY PLOICY -->

<div class="bgwhite">
<header class="bggreen">
        <div class="loginoverlay menublock hidden">
           <div class="container_24"> 
            <div class="cls_menu"></div>
            <ul>
       <li class="menu1">{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
   <?php   $pagename= DB::table('tour_content')->first(array('pagename'));         
           $pagename= $pagename->pagename;
           $url1= DB::table('tour_seo')->where('pagename',$pagename)->lists('url');   ?>
           
    <li class="menu1">  <a href="{{URL::to('/')}}/tour/{{$url1[0]}}" >Tour</a></li>
    <li class="menu1">{{ HTML::link('/plan', 'Sign Up') }}</li>
    <li class="menu1">{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
      <?php $parent = DB::table('tour_content')->where('parentpage','1')->get(array('pagename'));
        foreach($parent as $value){
		$pagename = $value->pagename; 
		$url = DB::table('tour_seo')->where('pagename',$pagename)->get(array('url'));
		foreach($url as $val){
			?>
			  <li class="menu1">  <a href="{{URL::to('/')}}/{{$val->url}}" >{{$pagename}}</a></li>
		<?php } 
		}
     ?>
    </ul>
            </div>
        </div>
        <div class="loginoverlay loginblock hidden">
           <div class="container_24"> 
            <div class="cls_login"></div>           
           
            {{ Form::open(array('method'=>'POST','url'=>'login','class' => 'userlogin')) }}
                <!-- check for login errors flash var -->
                {{ Form::label('user login', 'USER LOGIN', array('class' => 'grid_110')) }}
                <div class="clear"></div>
                <!-- username field -->
                {{ Form::text('username','', array('placeholder'=>'Username','class' => 'grid_190')) }}
                <!-- password field -->
                {{ Form::password('password', array('placeholder'=>'Password','class' => 'grid_190')) }}
                <!-- submit button -->
                {{ Form::submit('Submit', array('class' => 'btn_login')) }}
            {{ Form::close() }}
            </div>
        </div>
    <div class="container_24">
        <div class="grid_8 logodiv">
            <a href="{{ URL::to('/') }}" >{{ HTML::image('img/logo_orig.png', 'Logo', array('id' => 'logoImg')) }}</a>
            <a href="{{ URL::to('/') }}" >{{ HTML::image('img/mobile_logo.png', 'Logo', array('id' => 'logoImg_mob','class'=>'mobile')) }}</a>
        </div><!--.logodiv-->
        <div id="logindiv" class="grid_540">
            <div class="lostpwd grid_3"><a href="#" class="pwdlink">Forgot Password?</a></div>
            <div class="clear"></div>
            {{ Form::open(array('url'=>'login','method'=>'POST','class' => 'userlogin')) }}
                <!-- check for login errors flash var -->
                {{ Form::label('user login', 'USER LOGIN', array('class' => 'grid_110')) }}
                <!-- username field -->
                {{ Form::text('username','', array('placeholder'=>'Username','class' => 'grid_190')) }}
                <!-- password field -->
                {{ Form::password('password', array('placeholder'=>'Password','class' => 'grid_190')) }}
                <!-- submit button -->
                {{ Form::submit('Submit', array('class' => 'btn_login')) }}
            {{ Form::close() }}
        </div>
        <div id="logindiv_mob" class="mobile">
            <div class="login_mob">LOGIN</div>
            <div class="menu_mob">MENU</div>
        </div>
    </div>
</header>
<div class="clear"></div>

<nav id="navigation" class="container_24">
    <ul>
       <li class="menu1">{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
   <?php   $pagename= DB::table('tour_content')->first(array('pagename'));         
           $pagename= $pagename->pagename;
           $url1= DB::table('tour_seo')->where('pagename',$pagename)->lists('url');   ?>
           
    <li class="menu1">  <a href="{{URL::to('/')}}/tour/{{$url1[0]}}" >Tour</a></li>
    <li class="menu1">{{ HTML::link('/plan', 'Sign Up') }}</li>
    <li class="menu1">{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
      <?php $parent = DB::table('tour_content')->where('parentpage','1')->get(array('pagename'));
        foreach($parent as $value){
		$pagename = $value->pagename; 
		$url = DB::table('tour_seo')->where('pagename',$pagename)->get(array('url'));
		foreach($url as $val){
			?>
			  <li class="menu1">  <a href="{{URL::to('/')}}/{{$val->url}}" >{{$pagename}}</a></li>
		<?php } 
		}
     ?>
    </ul>
</nav>
<div class="clear"></div>

@yield('featured')
@yield('feature_mob')
@yield('tour')
@yield('tour_mob')
@yield('tour_tablet')
<div class="clear"></div>

@yield('homewidget')
@yield('homewidget_mob')
@yield('homewidget_tablet')
<div class="clear"></div>

<div class="container_24">
    @yield('content')
</div>
<footer class="bggreen">
    <div class="container_24 width1206">
        <div class="copyright grid_24">© 2013 Minitmeet     <span class="centerline">|</span>   {{ HTML::link('/', 'Home', array('title' => 'Home page')) }}     {{ HTML::link('/', 'Privacy Policy', array('class'=>'privacylink', 'title' => 'Privacy Policy')) }}     {{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}     {{ HTML::linkAction('TourController@index', 'Tour') }}</div>
        <div class="grid_3 footerlogo">{{ HTML::image('img/footer_logo.jpg', 'Company Logo') }}</div>
    </div> 
    <div class="copyright_mob mobile">© 2013 Minitmeet     <span class="centerline">|</span>   {{ HTML::link('/', 'Home', array('title' => 'Home page')) }}     {{ HTML::link('/', 'Privacy Policy', array('class'=>'privacylink', 'title' => 'Privacy Policy')) }}     {{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}     {{ HTML::linkAction('TourController@index', 'Tour') }}</div>
</footer>
</div><!--.bgwhite-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<script type="text/javascript">

 function Addclass(str){
	 var pathname = window.location.href;	
	 var txtLink = document.getElementById('txtlink');
     var setLink = txtLink.parentNode.getElementsByTagName("href");     
	 jQuery(".one").click(function()
		{
			jQuery(".one").removeClass("active");
			jQuery(this).addClass("active");

		});
console.log();
	
 }
</script>
<script type="text/javascript">
/*Slider Code*/

var int=self.setInterval(function(){changeImge()},2000);
var i=1;
$("#myid li").click(function() {
 i = Number(this.id);
 changeImge();
});


function changeImge(){
    var total =jQuery('.slider img').size();   
    if(i >= total){i=0;}
    jQuery('.slider ul li').removeClass('active');
    jQuery('.slider img').hide();
    i=i+1;
    jQuery('.slider ul li:nth-child('+i+')').addClass('active');
    jQuery('.slide'+i).fadeIn();
}
</script>
<script type="text/javascript">
(function(){
    /*Mobile Homw widget slider*/
    jQuery('.homewidget_mob_wrapper').click(function(){
        jQuery(this).next().slideToggle();
    });

    jQuery('.closeform').click(function(){
        jQuery('.pwd_display').fadeOut();
        jQuery('#recoverpwd').fadeOut();  
    });
    jQuery('.pwdlink').click(function(){
        jQuery('.err').hide();
        jQuery('.pwd_display').fadeIn();
        jQuery('#recoverpwd').fadeIn();
    });
    /*Showing Terms adnd condition*/
        jQuery('.termsclose').click(function(){
        jQuery('.terms_div').fadeOut();
        jQuery('.terms-overlay').fadeOut();  
    });
    jQuery('.termslink').click(function(e){
        e.preventDefault();
        jQuery('.terms_div.rterms').fadeIn();
        jQuery('.terms-overlay').fadeIn();
    });
    jQuery('.privacylink').click(function(e){
        e.preventDefault();
        jQuery('.terms_div.privacy').fadeIn();
        jQuery('.terms-overlay').fadeIn();
    });
    /*End Terms*/
    jQuery('.cls_menu').click(function() {
        jQuery('.menublock').slideUp(function(){
            jQuery('.login_mob').show();
            jQuery('.menu_mob').show();
        });
    });
    jQuery('.menu_mob').click(function() {
        jQuery('.menublock').slideDown(function(){
            jQuery('.login_mob').hide();
            jQuery('.menu_mob').hide();
        });
    });
    jQuery('.cls_login').click(function() {
        jQuery('.loginblock').slideUp(function(){
            jQuery('.login_mob').show();
            jQuery('.menu_mob').show();
        });
    });
    jQuery('.login_mob').click(function() {
        jQuery('.loginblock').slideDown(function(){
            jQuery('.login_mob').hide();
            jQuery('.menu_mob').hide();
        });
    });
})();
</script>
<script type="text/javascript">
$(document).ready(function(){
		var cur_url = window.location.href;
		var menu_id = $('.submenu a[href^="'+cur_url+'"]').parent('li').addClass('active');
		//alert("hello"+menu_id);
		//if(window.location.hash == $(this).attr('href')) 
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
		var cur_url = window.location.href;
		var menu_id = $('.menu1 a[href^="'+cur_url+'"]').parent('li').addClass('home');
		//alert("hello"+menu_id);
		//if(window.location.hash == $(this).attr('href')) 
	});
</script>
 <?php if(isset($err) && $err == "empty"){ ?>
<script type="text/javascript">
    jQuery('.pwd_display').fadeIn();
    jQuery('#recoverpwd').fadeIn();
    jQuery('.err').show();
    jQuery('.closeform').click(function(){
        jQuery('.pwd_display').fadeOut();
        jQuery('#recoverpwd').fadeOut();  
    });
</script>-->
 <?php } ?>
@yield('call')
</body>
</html>
