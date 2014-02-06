 @if(Auth::check())
<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html dir="ltr" lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title>Minitmeet - Dashboard</title>	
		
		<!-- 1140px Grid styles for IE -->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->

		<!-- The 1140px Grid -->
		<link rel="stylesheet" href="{{URL::to('/')}}/_layout/1140.css" type="text/css" media="screen" />
		
		
		<link rel="stylesheet" href="{{URL::to('/')}}/_layout/styles.css" type="text/css" media="screen" />
		<link rel='stylesheet' href='{{URL::to('/')}}/_themes/default.css' type='text/css' media='screen' />

		
		<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
		<script type="text/javascript" src="{{URL::to('/')}}/_layout/scripts/css3-mediaqueries.js"></script>
		
			
		<!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold|PT+Sans+Narrow:regular,bold|Droid+Serif:iamp;v1' rel='stylesheet' type='text/css' />
		
		
		<!-- Scripts -->
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js?ver=1.6'></script>
	
		
		<!-- Charts -->
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/jquery.raphael/raphael-min.js'></script>
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/jquery.morris/morris.min.js'></script>
	
		
		<!-- WYSISYG Editor -->
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/nicEdit/nicEdit.js'></script>
		
		
		<!-- Forms Elemets -->
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/jquery.uniform/jquery.uniform.min.js'></script>
		<link rel='stylesheet' href='{{URL::to('/')}}/_layout/scripts/jquery.uniform/uniform.default.css' type='text/css' media='screen' />
		
		
		<!-- Table sorter -->
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/jquery.tablesorter/jquery.tablesorter.min.js'></script>
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/table.resizable/resizable.tables.js'></script>
		
		
		<!-- Lightbox - Colorbox -->
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/scripts/jquery.colorbox/jquery.colorbox-min.js'></script>
		<link rel='stylesheet' href='{{URL::to('/')}}/_layout/scripts/jquery.colorbox/colorbox.css' type='text/css' media='screen' />
		
		
		<script type='text/javascript' src='{{URL::to('/')}}/_layout/custom.js'></script>
		
	
<script type="text/javascript" src="{{URL::to('/tinymce/js')}}/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    height : 200,
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
</script>

<style>

input[type="text"] {
    border: 1px solid #D0D0D0;
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2) inset, 1px 2px 3px 0 rgba(0, 0, 0, 0.1);
    color: #565656;
    display: block;
    font-family: Arial,Verdana;
    font-size: 12px;
    height: 26px;
    padding: 4px 12px;
    transition: box-shadow 0.3s ease 0s;
    width: 96% !important;
}
</style>
@yield('head')
<!-- CDN hosted by Cachefly -->
    <title>MinitMeet - @yield('title')</title>
   
</head>
<body>
<div id="header-wrapper" class="container">
		<div id="user-account" class="row" >
			<div class="threecol"><span>Welcome to Admin Dashboard </span> </div>
			<div class="ninecol last">{{ HTML::link('logout', 'Logout',array('class'=>'bluebutton')) }} <span></span> <span>Welcome, <strong>@if(Auth::check()){{strtoupper(Auth::User()->first_name)}} {{Auth::User()->last_name}} @endif</strong></span> </div>
		</div>

		<div id="user-options" class="row">
			<div class="threecol"><a href="{{URL('admin')}}"><img class="logo" src="{{URL::to('/')}}/images/Minitmeet_logo.png" alt="MinitAdmin" /></a></div>
			
		</div>
	</div>
	
<div class="container">
		<div class="row">
		
			<div id="sidebar" class="threecol">
				<ul id="navigation">
					<li class="first active"> <a href="{{URL::to('/admin/pages')}}">CMS<span class="icon-dashboard"></span></a></li> 
					<li><a href="{{URL::to('/admin/users')}}">Users <span class="icon-charts"></span></a></li>
					<li><a href="{{URL::to('/admin/payment')}}">Payment <span class="icon-forms"></span></a></li>					
					<li><a href="{{URL::to('/admin/orders/review')}}">Orders <span class="icon-forms"></span></a></li>
					<li class="sub">
						<a href="#l">Email <img src="{{URL::to('/')}}/_layout/images/back-nav-sub-pin.png" alt="" /> <span class="icon-error"></span></a>
						<ul>
							<li><a href="{{URL::to('/admin/mail/one')}}">Mail To One</a></li>							
							<li class="last"><a href="{{URL::to('admin/mail/many')}}">Mail To Many </a></li>
						</ul>
					</li> 							
				</ul>
			</div>	
	
	
<div id="content" class="ninecol last">
          @if(Auth::check())
                @yield('content')
            @endif
        </div>
    </div><!--#wrapper-->
</div><!--.bgsilver-->
<div class="clear"></div>



  
<script type="text/javascript">

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

</script>


<script type="text/javascript">
/*Slider Code*/
var int=self.setInterval(function(){changeImge()},4000);
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
  
</body>
</html>
 
  @else
  <a href="{{URL::to('')}}">click here to login</a>
  @endif
 
