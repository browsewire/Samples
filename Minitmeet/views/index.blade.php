@extends('layout/main')

@section('title')
Home
@endsection

@section('topnav')
    <li class="home">{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
    <li>{{ HTML::linkAction('TourController@index', 'Tour') }}</li>
    <li>{{ HTML::link('/register', 'Sign Up') }}</li>
    <li>{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
@endsection

@section('featured')
<div id="featured" class="bgsilver">
    <div class="container_xam">
    <div class="container_24">
    <?php   $pagename= DB::table('tour_content')->where('parentpage','tour')->lists('pagename');         
           $url1 = DB::table('tour_seo')->where('pagename',$pagename[0])->lists('url');
           $url2 = DB::table('tour_seo')->where('pagename',$pagename[1])->lists('url');
           $url3 = DB::table('tour_seo')->where('pagename',$pagename[2])->lists('url');
           $url4 = DB::table('tour_seo')->where('pagename',$pagename[3])->lists('url');     
           
              ?>
        <div class="grid_10 featbutton">{{ HTML::link('/plan', 'FREE SIGNUP',array('class'=>'button_medium btn_signup')) }} <a href="{{ URL::to('/') }}/tour/{{$url1[0]}}" class="button_medium btn_tour">TAKE TOUR</a></div>
    </div>
    </div>
</div>
<div class="clear"></div>
<div class="container_24 heading_wrapper">
{{ HTML::image('img/heading_06.jpg', 'Logo', array('id' => 'logoImg', 'class' => 'left-20')) }}

</div>
@endsection

@section('feature_mob')
<div id="featured_mob" class="mobile bggreen">
<div class="feat_wrapper_mob">
<div class="grid_10 featbutton_mob mobile">{{ HTML::link('/plan', 'FREE SIGNUP',array('class'=>'button_medium btn_signup')) }} <a href="{{ URL::to('/') }}/tour/{{$url1[0]}}" class="button_medium btn_tour">TAKE TOUR</a></div>
</div>
</div>
@endsection

@section('homewidget_mob')
<div id="homewidget_mob">
    <div class="homewidget_mob_wrapper">
        <div class="whyminit container_24">
        </div>
    </div>
     <div class=" widget1 hidden widget_mob_pad">
        <h5>Still Doing it the Old Fashion Way?</h5>
        <p>Minitmeet takes a new and clever approach to produce professional looking meeting minutes a very pleasant experience</p>
    </div>
    <div class="homewidget_mob_wrapper">
        <div class="whouse container_24"></div>
    </div>
    <div class="hidden widget_mob_pad widget2">
        <h5>The Perfect Solution for Business</h5>
        <p>Minitmeet is the perfect solution for all businesses who want to easily capture, distribute & track all of their daily meeting minutes</p>
    </div>
</div>

@endsection

@section('homewidget')
<div id="homewidget" class="container_24">
    <div class="grid_540 widget1 left-20">
        <div class="lefticon icon_note">&nbsp;</div>
        <h5 style="width: 530px;">Still Doing it the Old Fashion Way?</h5>
        <p style="width: 530px;">Minitmeet takes a new and clever approach to produce professional looking meeting minutes a very pleasant experience</p>
    </div>
    <div class="grid_540 widget2">
        <div class="lefticon icon_mob">&nbsp;</div>
        <h5 style="width: 530px;">The Perfect Solution for Business</h5>
        <p style="width: 530px;">Minitmeet is the perfect solution for all businesses who want to easily capture, distribute & track all of their daily meeting minutes</p>
    </div>
</div><!--#homewidget-->
<div id="showcase" class="container_24">
    <div class="bggray grid_540 padding_20 showcase_left">
        <div class="icon_minute">&nbsp;</div>
        <p>Save your meeting minutes as a draft to send later. <a href="{{URL::to('/')}}/tour/{{$url1[0]}}">Learn More</a></p>
        <div class="icon_contact">&nbsp;</div>
        <p>Add, Edit & Delete Contacts.  <a href="{{URL::to('/')}}/tour/{{$url4[0]}}">Learn More</a></p>
    </div>
    <div class="bggray grid_540 padding_20">
        <div class="icon_setting">&nbsp;</div>
        <p>Customize the logo, font & color of your Minitmeet document.  <a href="{{URL::to('/')}}/tour/{{$url3[0]}}">Learn More</a></p>
        <div class="icon_pdf">&nbsp;</div>
        <p>Email Minitmeet directly to the meeting attendees as a PDF.  <a href="{{URL::to('/')}}/tour/{{$url2[0]}}">Learn More</a></p>
    </div>
</div>
@endsection
@section('homewidget_tablet')
<div class="bg_tablet tablet"></div><div class="bg_wrapper_tab"></div>
<div class="hding_wrap_tablet tablet">
<div class="container_24">
<div class="whyminit_tablet grid_12"></div><div class="whouse_tablet grid_12"></div>
</div>
</div> 
<div class="clear"></div>
<div id="homewidget_tablet" class="container_24 tablet">
    <div class="grid_12 widget1 left-20">
        <div class="lefticon icon_note">&nbsp;</div>
        <h5>Still Doing it the Old Fashion Way?</h5>
        <p>Minitmeet takes a new and clever approach to produce professional looking meeting minutes a very pleasant experience</p>
    </div>
    <div class="grid_12 widget2">
        <div class="lefticon icon_mob">&nbsp;</div>
        <h5>The Perfect Solution for Business</h5>
        <p>Minitmeet is the perfect solution for all businesses who want to easily capture, distribute & track all of their daily meeting minutes</p>
    </div>
</div><!--#homewidget-->
<div id="showcase_tablet" class="container_24 tablet">
    <div class="bggray grid_11 padding_20 showcase_left">
        <div class="icon_minute">&nbsp;</div>
        <p>Save your meeting minutes as a draft to send later.   <a href="{{URL::to('/')}}/tour/{{$url1[0]}}">Learn More</a></p>
        <div class="icon_contact">&nbsp;</div>
        <p>Add, Edit & Delete Contacts.   <a href="{{URL::to('/')}}/tour/{{$url4[0]}}">Learn More</a></p>
    </div>
    <div class="bggray grid_11 padding_20">
        <div class="icon_setting">&nbsp;</div>
        <p>Customize the logo, font & color of your Minitmeet document.   <a href="{{URL::to('/')}}/tour/{{$url3[0]}}">Learn More</a></p>
        <div class="icon_pdf">&nbsp;</div>
        <p>Email Minitmeet directly to the meeting attendees as a PDF.   <a href="{{URL::to('/')}}/tour/{{$url2[0]}}">Learn More</a></p>
    </div>
</div>
@endsection
@section('content')

@endsection
