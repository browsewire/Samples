@extends('layout/main')

@section('title')
Reset Password
@endsection

@section('topnav')
    <li class="home">{{ HTML::linkAction('TourController@index', 'Tour') }}</li>
    <li>{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
    <li>{{ HTML::link('/register', 'Sign Up') }}</li>
    <li>{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
@endsection

@section('tour')
<div class="bgsilver clearfix">
    <div id="wrapper" class="container_24 bgwhite padding_30 logindiv register_wrapper">
<div class="darkgray title fan-top"><strong>Password Reset</strong></div>
<div class="bggray padding_20 brsilver_topwhite fan login_inner">
@if ($expire == 'no')
   {{ Form::open(array('url'=>'reset','method'=>'POST','class'=>'signup clearfix loginpage')) }}
    <!-- check for login errors flash var -->
    @if(Session::has('login_errors'))
        <span class="error label label-warning">Username or password incorrect. Register your account {{ HTML::link('/register','Reigster') }}</span>
    @endif
    <input type="hidden" value="{{ Input::get('token') }}" name="token">
    <!-- First name field -->
    <div class="grid_5 alignright padtop_2">New Password<span class="red">*</span>:</div>
    <input type="password" name="newpwd" class="grid_9" min="4" required>
    <div class="clear"></div>
    <!-- Last name field -->
    <div class="grid_5 alignright padtop_2">Confirm Password<span class="red">*</span>:</div>
    <input type="password" name="checkpwd" class="grid_9" min="4" required>
    <div class="clear"></div>
    <!-- submit button -->
    <div class="grid_5">&nbsp;</div><div class="grid_4"><button type="submit" class="medium_button signupbtn">SUBMIT</button></div>
    {{ Form::close() }}
@else
    <div>Session has expired for this key.</div>
@endif
</div>
</div>
</div>
@endsection



</body>
</html> 
