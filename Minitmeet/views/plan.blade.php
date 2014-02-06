@extends('layout/main')

@section('title')
Plan
@endsection
@section('css')
<style> 
.price-section {
    background-color: #EFEFEF;
    border: 1px solid #CCCCCC;
    float: left;
    min-height: 400px;
    margin: 0 1%;
    padding: 2% 3%;
    width: 25%;
} 

.price-text-lists li {
    display: list-item;
    font-size: 14px;
    line-height: 20px;
    margin-top: 10px;
    text-align: center;
} 
.price-section p{ 
text-align: center;    color: #FFFFFF;
}

.price-text-lists p {
    color: black !important;
    font-size: 14px;
}
.price-section-inner p a {
    background: none repeat scroll 0 0 #F28F00;
    border: medium none;
    border-radius: 0 0 0 0;
    color: #FFFFFF;
    display: block;
    font-family: "Trebuchet MS",Helvetica,sans-serif;
    font-size: 19px;
    font-weight: bold;
    margin: 0 auto;
    text-align: center;
    text-shadow: 1px 1px 0 #DA6300;
    font-style: normal;
}
.price-section h1 {
     color: #6A6564;
    font-family: "Trebuchet MS",Helvetica,sans-serif;
    font-size: 1.4em;
    font-weight: bold;
    line-height: 1.95em;
    margin-bottom: 0;
    padding: 0 0 0 2%;
    text-align: center;
    text-transform: uppercase;
}
.price-section-inner {
    background-color: #0190A9;
    border: 1px solid #CCCCCC;
    height: auto;
    padding: 4% 10% 0;
}

.login_inner {
    background-color: white!important;
    padding: 20px 20px 30px;
    width: 96%;
}
	span.price-big {
    color: #FFFFFF;
    font-family: "Trebuchet MS",Helvetica,sans-serif;
    font-size: 45px;
}
a#pro-button, a#team-button {
    padding: 4% 12%;
}
.price-section-upper {
    display: inline-block;
    width: 100%;
}
.header-image img {
    width: 100%;
}
#pro.price-section-upper .header-image {
    padding-left: 22%;
}
.header-image {
    float: left;
    width: 17%;
}
</style>
@endsection
@section('tour')
<div class="bgsilver clearfix">
    <div id="wrapper" class="container_24 bgwhite padding_30 logindiv register_wrapper">
<div class="darkgray title fan-top"><strong>Select Your Plan</strong></div>
<div class="bggray padding_20 brsilver_topwhite login_inner">
<div id="price-container-outer">
<div id="price-container">

@foreach($data as $value)

<div class="price-section">
<div class="price-section-upper" id="pro">
<h1>{{$value->plan}}</h1>
</div>
<div class="price-section-inner">
<p style="padding-top: 1%;">&nbsp;</p>
<p><span class="price-big">${{$value->plan_price}}</span></p>
<p style="padding-top: 1%;">&nbsp;</p>
<p class="centered">{{$value->plan_description}}</p>
<p class="centered">&nbsp;</p><p class="centered">&nbsp;</p>
<p><a class="centered" href="{{URL::to('/plan')}}/{{$value->plan_name}}" id="pro-button">Select</a></p>
<p>&nbsp;</p>
</div>
<div class="price-text-lists" style="color:black;!important">
{{$value->plan_subdescription}}</div>
</div>
@endforeach

</div>
</div>
</div>
</div>
@endsection



</body>
</html> 
