@extends('layout/main')
@section('meta')
<?php  
    foreach($seo as $value){
?>
<title>{{$value->title}}</title>
<meta name="description" content="{{$value->description}}">
<meta name="keywords" content="{{$value->keyword}}">
<?php   } 
      
 ?>
@endsection
@section('css')
<style>
.login_inner {
   
    padding: 20px 20px 30px;
    width: 96%;
}
</style>
@endsection
@section('tour')
<div class="bgsilver clearfix">
@foreach($data as $value)
    <div id="wrapper" class="container_24 bgwhite padding_30 logindiv register_wrapper">
<div class="darkgray title fan-top"><strong>{{$value->title}}</strong></div>
<div class="bggray padding_20 brsilver_topwhite login_inner">
<div id="price-container-outer">
<div id="price-container">

{{$value->content}} 


@endforeach
</div>
</div>
</div>
</div>
@endsection



</body>
</html> 
