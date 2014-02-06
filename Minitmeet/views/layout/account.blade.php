<!DOCTYPE HTML>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=480px"> 
<link rel="icon" type="image/png" href="http://minitmeet.com/img/favicon.png">
    <title>MinitMeet - @yield('title')</title>
    @yield('css')
     <link href="{{URL::to('css/style.css')}}" rel="stylesheet">
</head>
<body class="bggreen">
<div class="addcontact_div task_bg">
    <div class="closeform addcontact_close"></div> 
<a class="plusbutton tab-desk tutplus" href="{{ URL::to('/account/create') }}">Create New MINITS</a>
</div>
<div class="pwd_display addcontact-overlay">
</div>
<!-- PRVACY POLICY -->
<div class="terms_div privacy">
    <div class="closeform termsclose"></div> 
    <div id="conditions">
{{ View::make('layout.privacy') }}
    </div>      
</div>
<div class="pwd_display terms-overlay"></div>
<!-- END OF PRVACY PLOICY -->
        <div class="loginoverlay menublock hidden">
           <div class="container_24"> 
            <div class="cls_menu"></div>
            <ul>
                <li>{{ HTML::linkAction('AccountController@index', 'Overview') }}</li>
                <li>{{ HTML::linkAction('AccountController@contacts', 'Contacts') }}</li>
                <li>{{ HTML::linkAction('AccountController@tasks', 'Tasks') }}</li>
           </ul>
            </div>
        </div>
        <div class="loginoverlay loginblock hidden">
           <div class="container_24"> 
            <div class="cls_login"></div>
            <ul>
                <li>{{ HTML::linkAction('AccountController@preferences', 'Settings') }}</li>
                <li>{{ HTML::link('logout', 'Logout') }}</li>
           </ul>
            </div>
        </div>
<div class="bgwhite">
<header class="bggreen steinem">
    <div class="container_24">
        <div class="grid_8 logodiv">
            <a href="{{ URL::to('account'); }}" >{{ HTML::image('img/logo_orig.png', 'Logo', array('id' => 'logoImg')) }}</a>
            <a href="{{ URL::to('account'); }}" >{{ HTML::image('img/mobile_logo.png', 'Logo', array('id' => 'logoImg_mob','class'=>'mobile')) }}</a>
        </div><!--.logodiv-->
        <div class="logout">
            <div class="loghandler grid_7 white prefix_12"><div class="left">Logged in as : </div><span class="dbrown left">{{ Auth::user()->username }}</span>
            <div class="right grid_2">{{ HTML::link('logout', 'Logout',array('class'=>'bluebutton')) }}</div>
            </div>
       </div>
        <div id="logindiv_mob" class="mobile">
            <div class="login_mob">{{ Auth::user()->username }}
                <?php  ?>
            </div>
            <div class="menu_mob">MENU</div>
        </div>
    </div>
</header>
<div class="clear"></div>

<nav id="navigation2" class="tab-desk container_24 account">
    <ul>
        @yield('topnav')
    </ul>
    <div class="settings">{{ HTML::linkAction('AccountController@preferences', 'Settings') }}</div>
</nav>
<div class="clear"></div>
 @yield('createminit')
<div class="create_bg clearfix">
    <div id="wrapper" class="container_24 create_wrapper">
        <div>
                @yield('content')
            
        </div>
    </div><!--#wrapper-->
</div><!--.bgsilver-->
<div class="clear"></div>

<footer class="bggreen">
    <div class="container_24 width1206">
        <div class="copyright grid_24">© 2013 Minitmeet     <span class="centerline">|</span>   {{ HTML::link('/', 'Home', array('title' => 'Home page')) }}     {{ HTML::link('/', 'Privacy Policy', array('class'=>'privacylink', 'title' => 'Privacy Policy')) }}     {{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}     {{ HTML::linkAction('TourController@index', 'Tour') }}</div>
        <div class="grid_3 footerlogo">{{ HTML::image('img/footer_logo.jpg', 'Company Logo') }}</div>
    </div> 
    <div class="copyright_mob mobile">© 2013 Minitmeet     <span class="centerline">|</span>   {{ HTML::link('/', 'Home', array('title' => 'Home page')) }}     {{ HTML::link('/', 'Privacy Policy', array('class'=>'privacylink', 'title' => 'Privacy Policy')) }}     {{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}     {{ HTML::linkAction('TourController@index', 'Tour') }}</div>
</footer>
</div><!--.bgwhite-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
   
  
   <script src="{{URL::to('jscripts/tiny_mce/tiny_mce.js')}}"></script> 
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script> 
     <script src="{{URL::to('js/colorpicker.js')}}"></script> 
      <script src="{{URL::to('js/xam.js')}}"></script> 
       <script type="text/javascript" src="{{URL::to('datepicker/datexam.js')}}"></script>

@yield('phpFunctions')
<script type="text/javascript">
(function(){
    /*Task drop down Menu*/
    jQuery('.task_menu').unbind('click').click(function(){
        jQuery(this).children('.task_submenu').fadeToggle();
    });
        /*Showing add contact*/
        jQuery('.addcontact_close').click(function(e){
            e.preventDefault;
        jQuery('.addcontact_div').fadeOut();
        jQuery('.addcontact-overlay').fadeOut();  
    });
    jQuery('.add_contact').click(function(e){
        e.preventDefault;
        jQuery('.addcontact_div').removeClass('task_bg').fadeIn();
        jQuery('.addcontact-overlay').fadeIn();
    });
    jQuery('.add_task').click(function(e){
        e.preventDefault;
        jQuery('.addcontact_div').addClass('task_bg').fadeIn();
        jQuery('.addcontact-overlay').fadeIn();
    });
        /*Showing Terms adnd condition*/
    jQuery('.termsclose').click(function(){
        jQuery('.terms_div').fadeOut();
        jQuery('.terms-overlay').fadeOut();  
    });
    jQuery('.privacylink').click(function(e){
        e.preventDefault();
        jQuery('.terms_div.privacy').fadeIn();
        jQuery('.terms-overlay').fadeIn();
    });
    /*End Add contact*/
    jQuery('.closeform').click(function(){
        jQuery('.pwd_display').fadeOut();
        jQuery('#recoverpwd').fadeOut();  
    });
    jQuery('.pwdlink').click(function(){
        jQuery('.err').hide();
        jQuery('.pwd_display').fadeIn();
        jQuery('#recoverpwd').fadeIn();
    });
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
/* TINYCME*/
function clearPlaceholder(){
   if(tinyMCE.get('agenda').getContent() === '<p><span class="bigfont">Draft Meeting Agenda or <span class="brown">Load Template</span>.</span></p>'){
    tinyMCE.get('agenda').setContent('');
   }
}
function placeholder() {
    if(tinyMCE.get('agenda').getContent() === ''){
    tinyMCE.get('agenda').setContent('<p><span class="bigfont">Draft Meeting Agenda or <span class="brown">Load Template</span>.</span></p>');
   }
}
function myCustomInitInstance(ed) {
    var s = ed.settings;
    var realID = ed.id+'_tbl';
    tinymce.dom.Event.add(ed.getWin(), 'focus', function(e) {
        clearPlaceholder();

    });
    tinymce.dom.Event.add(ed.getWin(), 'blur', function(e) {
        placeholder();
    
    });
}
    tinyMCE.init({ mode : "textareas",theme : "simple",width:'100%',height:345,init_instance_callback: myCustomInitInstance});
</script>
</body>
</html>
