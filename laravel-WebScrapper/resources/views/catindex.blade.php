@extends('layouts.app')

@section('title',  $type.' '.$posttype->title )

@section('sidebar')
    
    @parent

    
@endsection

@section('content')
 <div id='content'>
  <h1>Filter By {{ $type }} "{{ $posttype->title}}"</h1>
  <div class="row">
  
  @foreach ($categlist as $post)
  <div class="post-list">
     <h4>
       @foreach ($post->ptopics as $topics)
            <a href="{{ URL::to( 'category/' .  $topics->slug  ) }}">{{ $topics->title }}</a> /
       @endforeach
     </h4>
     <h2><a href="{{ URL::to( 'show/' .  $post->slug  ) }}">{{ str_limit($post->title, $limit = 50, $end = '...') }}  </a></h2>
     
     <h4>{{ $post->topics }}</h4>
     <span>{{$post->created }} <i>By {{$post->author }}</i></span>
     <p>{{ strip_tags(str_limit($post->content, $limit = 150, $end = '...') )}}<a href="{{ URL::to( 'show/' .  $post->slug  ) }}">Read More</a></p>
     
    
 </div>
  @endforeach
  
  {{$categlist->links()}}
  </div>
 
 </div>
 
@endsection 