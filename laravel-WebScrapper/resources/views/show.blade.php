@extends('layouts.app')

@section('title', $post->title)

@section('sidebar')
    
    @parent

    
@endsection

@section('content')
 <div id='content'>
 <div class="row">
 <div class="left-content">
 
 
 
 <h4>
 @foreach ($post->ptopics as $topics)
      <a href="{{ URL::to( 'category/' .  $topics->slug ) }}">{{ $topics->title }}</a> /
 @endforeach
 </h4>
 <h1><a href="{{$post->url }}" target="_blank">{{$post->title }}</a></h1>
 
 <span>{{$post->created }} <i>By {{$post->author }}</i></span>
 <p class="tags" >TAGS: 
    @foreach ($post->ptags as $tag)
      <a href="{{ URL::to( 'tag/' .  $tag->slug ) }}">{{ $tag->title }}</a> /
     @endforeach
 </p>
 {!! $post->content !!}
 
 
 <div class="pagination">
 @if($previous) 
 <a href="{{ URL::to( 'show/' . $previous->slug ) }}" class="prev" title="{{$previous->title}}"><span>«</span>{{ str_limit($previous->title, $limit = 50, $end = '...') }}</a>
 @endif
 @if($next) 
 <a href="{{ URL::to( 'show/' . $next->slug ) }}" class="next" title="{{$next->title}}">{{ str_limit($next->title, $limit = 50, $end = '...') }}<span>»</span></a>
 @endif
 </div>
 

 </div>
 
 
 <div class="right-sidebar">
 
   <h2>Recently Posted</h2>
   <ul>
   @foreach ($data as $user)
   
    <li><a href="{{ URL::to( 'show/' .  $user->slug ) }}">{{ $user->title }}  </a></li>
   
   @endforeach
 <ul>
 </div>
 
 
 </div>
 </div>
 
@endsection