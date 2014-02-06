@extends('layout/main')

@section('logo')
minitmeet
@endsection

@section('title')
Take tour
@endsection

@section('navigation')
    @parent
    <li><a href="#">About</a></li>
@endsection

@section('content')
<div class="span2 offset2">
<h3>Sidebar</h3>
<ul class="nav nav-list">
    <li>{{ HTML::linkAction('TourController@index', 'Overview') }}</li>
    <li>{{ HTML::linkAction('TourController@create','Create') }}</li> 
    <li>{{ HTML::linkAction('TourController@pdf','PDF') }}</li> 
    <li>{{ HTML::linkAction('TourController@contacts','Contact List') }}</li> 
    <li>{{ HTML::linkAction('TourController@settings','Settings') }}</li> 
</ul>

</div>
<div class="span6">
    <h1>Tour For Settings Page</h1>
    <p>Welcome to Tour PAGE!</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
@endsection
