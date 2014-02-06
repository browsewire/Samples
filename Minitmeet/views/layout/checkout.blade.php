<!DOCTYPE HTML>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=480px">
<link rel="icon" type="image/png" href="{{URL::to('img/favicon.png') }}">
    <title>MinitMeet - @yield('title')</title>
   <link href="{{URL::to('css/check/style.css')}}" rel="stylesheet">
   
    <!--[if IE]>
<link href="{{ URL::to('css/ie.css') }}" media="all" type="text/css" rel="stylesheet">
<![endif]-->

<style>
img {
    color: transparent;
    font-size: 0;
    height: 64px;
    margin-left: 105px;
    vertical-align: middle;
}
#logindiv {
    background-color: #00341E;   
    position: static;   
    width: 100%;
}

</style>
</head>
<body class="bggreen">
<!-- Forgot password overlay -->
 
<div class="pwd_display">
</div>
<!-- END -->
<!-- TERMS OVERLAY -->

</div>
<!-- END TERMS OVERLAY -->
<!-- PRVACY POLICY -->

<div class="pwd_display terms-overlay"></div>
<!-- END OF PRVACY PLOICY -->

<div class="bgwhite">
<header class="bggreen">       
  <div id="logindiv"> <a href="" >{{ HTML::image('img/logo_orig.png', 'Logo', array('id' => 'logoImg')) }}</a>
        </div>
         
           
      
</header>
<div class="clear"></div>

<nav id="navigation" class="container_24">
    <ul>
        @yield('topnav')
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

@yield('call')
</body>
</html>
