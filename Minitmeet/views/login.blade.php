@extends('layout/main')

@section('title')
Login
@endsection

@section('topnav')
    <li>{{ HTML::link('/', 'Home', array('title' => 'Home page')) }}</li>
    <li>{{ HTML::linkAction('TourController@index', 'Tour') }}</li>
    <li>{{ HTML::link('/register', 'Sign Up') }}</li>
    <li>{{ HTML::link('/faq', 'FAQ', array('title' => 'Frequently Asked Questions')) }}</li>
@endsection

@section('tour')
<div class="bgsilver clearfix">
    <div id="wrapper" class="container_24 bgwhite padding_30 logindiv register_wrapper">
<div class="darkgray title fan-top"><strong>Login To Your Account</strong></div>
<div class="bggray padding_20 brsilver_topwhite fan login_inner">

   
    @if($success)
    <div class="signupAlert alert alert-success">
        <h2>{{ $success }}</h2>
    </div>
    @endif

    @if (Session::has('login_errors'))
            <div class="signupAlert alert alert-error">Username or password is incorrect.Kindly Provide valid information.</div>
    @endif
    @if (Session::has('register_success'))
            <div class="signupAlert alert alert-success"><strong>Successfully Registered!</strong> You can now login.</div>
    @endif

   {{ Form::open(array('url'=>'login','method'=>'POST','class'=>'signup clearfix loginpage')) }}
    <!-- check for login errors flash var -->
    @if (Session::has('login_errors'))
        <span class="error label label-warning"></span>
    @endif
    <!-- First name field -->
    <div class="grid_5 alignright padtop_2">Username<span class="red">*</span>:</div>
    {{ Form::text('username','',array('class'=>'grid_9', 'required'=>'required')) }}
    <div class="clear"></div>
    <!-- Last name field -->
    <div class="grid_5 alignright padtop_2">Password<span class="red">*</span>:</div>
    <input type="password" name="password" id="password" class="grid_9" required>
    <div class="clear"></div>
    <!-- submit button -->
    <div class="grid_5">&nbsp;</div><div class="grid_4"><button type="submit" class="medium_button signupbtn">SUBMIT</button></div>
    {{ Form::close() }}
</div>
</div>
</div>
@endsection



</body>
</html> 
