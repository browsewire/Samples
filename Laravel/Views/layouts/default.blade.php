<!DOCTYPE html>
  <!--[if lt IE 7]>
    <html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
  <![endif]-->

  <!--[if IE 7]>
    <html class="lt-ie9 lt-ie8" lang="en">
  <![endif]-->

  <!--[if IE 8]>
    <html class="lt-ie9" lang="en">
  <![endif]-->

  <!--[if gt IE 8]>
    <!-->
    <html lang="en">
    <!--
  <![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Welcome</title>
    <meta name="author" content="Srinu Basava">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="Sunrise Admin Admin UI">
    <meta name="keywords" content="Sunrise Admin, Admin UI, Admin Dashboard, Srinu Basava">
    <script src="{{URL::to('js/html5-trunk.js')}}"></script>
    <link href="{{URL::to('icomoon/style.css')}}" rel="stylesheet">
    <!--[if lte IE 7]>
    <script src="css/icomoon-font/lte-ie7.js"></script>
    <![endif]-->

    <link type="text/css" href="{{URL::to('css/jquery.dropdown.css')}}" rel="stylesheet"  />
    <!-- bootstrap css -->
    <link href="{{URL::to('css/main.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/fullcalendar.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/popup.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/notifiaction.css')}}" rel="stylesheet">
   <script type="text/javascript" src="{{URL::to('js/jquery-1.8.2.js')}}"></script>
 	<script type="text/javascript"> 
      $(document).ready( function() {
        $('#notification').delay(3000).fadeOut(2000);
      });
    </script>
	<script type="text/javascript" src="{{URL::to('js/jquery.dropdown.js')}}"></script>
	
  </head>
  <body>
    <header>
      <a href="{{URL::to('/')}}" class="logo">LOGO</a>
    </header>
	 @yield('content')
     
	 <footer>
      <p class="copyright">&copy;  xyz.com </p>
    </footer>
  
  </body>
</html>
