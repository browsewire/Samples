@extends('layouts.app')

@section('title', 'Edit Posts'.$post->title)

@section('sidebar')
    
    @parent

    
@endsection

@section('content')
 <div id='content'>
 <h1>Edit Posts </h1>
 <div class="form">  
      {!!  Form::open(array('action'=>'DemoController@update', 'method' => 'post')) !!}
    
          <div class="form-group">
              {!! Form::label('Title') !!}
              {!! Form::hidden('id', $post->id,array()) !!}
              {!! Form::text('title', $post->title,array('required','class'=>'form-control','placeholder'=>'Post Title')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::label('Author') !!}
              {!! Form::text('author', $post->author,array('required','class'=>'form-control', 'placeholder'=>'Author Name')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::label('URL') !!}
              {!! Form::text('url', $post->url,array('required','class'=>'form-control', 'placeholder'=>'Author Name')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::label('Topics') !!}
              {!! Form::text('topics', $post->topics,array('required','class'=>'form-control', 'placeholder'=>'Author Name')) !!}
          </div>
          
          <div class="form-group">
              {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
          </div>
      
      {!! Form::close() !!}
 </div>

 </div>
 
@endsection