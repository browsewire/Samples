@extends('layouts.app')

@section('title', 'Top News')

@section('sidebar')
    
    @parent

    
@endsection

@section('content')

 <div id='content'>
  
  <div class="row">
  @foreach ($posts as $post)
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
  
  {{$posts->links()}}
  </div>
  <!--
  <div class="row">
 <h1>Add New  Posts</h1>
 <div class="form">  
      {!!  Form::open(array('action'=>'DemoController@newpost', 'method' => 'post')) !!}
    
          <div class="form-group">
              {!! Form::label('Title') !!}
              {!! Form::text('title', null,array('required','class'=>'form-control','placeholder'=>'Post Title')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::label('Author') !!}
              {!! Form::text('author', null,array('required','class'=>'form-control', 'placeholder'=>'Author Name')) !!}
          </div>
          
           <div class="form-group">
              {!! Form::label('URL') !!}
              {!! Form::text('url', null,array('required','class'=>'form-control', 'placeholder'=>'URL')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::label('Topics') !!}
              {!! Form::text('topics', null,array('required','class'=>'form-control', 'placeholder'=>'Topics')) !!}
          </div>
          
          
          
          <div class="form-group">
              {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}
          </div>
      
      {!! Form::close() !!}
 </div>

 </div>
 -->
 </div>
 
@endsection