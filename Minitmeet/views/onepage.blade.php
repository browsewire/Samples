@extends('layout/main')

@section('title')
Plan
@endsection
@section('css')
<style>.check {
    height: 37px;
    margin-right: 36px;
}

#checkout{
    width: 1135px;
	margin:auto;
	}
	
.checkout{
	background:#F0F0F0;
	border:1px solid #CCCCCC;
	padding:30px;
	overflow: hidden;
	}
	
.chech_main{
	width:100%;
	float:left;
	}

.checkout_aao{
	float:left;
	width:27%;
	}

.checkout_aao h3{
	color: #141414;
    float: left;
    font-size: 14px;
	font-weight:bold;
	width:100%;
	margin-bottom:5px;
	line-height:22px;
	text-transform:uppercase;
	}
	
.checkout_aao_inside{
	float:left;
	width:100%;
	margin-top:10px;
	}
	
.checkout_aao_inside p{
	float:left;
	width:100%;
	margin-bottom:10px;
	font-size: 12px;
	}
	
.checkout_aao_inside p:last-child {
    margin-bottom: 0px;
}
	
.checkout_aao_inside p label{
	float:left;
	width:100%;
	font-size:12px;
	color:#000;
	line-height:22px;
	}
	
.checkout_aao_inside p input{
	 background:linear-gradient(to bottom, #E5E5E5 0%, #FFFFFF 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	width:96%;
	font-size:11px;
	color:#000;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	padding:5.5px;
	border:1px solid #FFFFFF;
	behavior: url(PIE.htc);
	position:relative;
	}
	
.checkout_aao_inside p select{
	 background:linear-gradient(to bottom, #E5E5E5 0%, #FFFFFF 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	width:100%;
	font-size:11px;
	color:#000;
	float:left;
	padding:5.5px;
	font-family:Arial, Helvetica, sans-serif;
	border:1px solid #FFFFFF;
	behavior: url(PIE.htc);
	position:relative;
	}
 
.checkout_aao_inside p span{
	float:left;
	width:48%;
	}

.checkout_aao_inside p span label{
	float:left;
	width:100%;
	font-size:12px;
	color:#000;
	line-height:22px;
	}
	
.checkout_aao_inside p span input{
	background:linear-gradient(to bottom, #E5E5E5 0%, #FFFFFF 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	width:91%;
	font-size:11px;
	color:#000;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	padding:5.5px;
	border:1px solid #FFFFFF;
	behavior: url(PIE.htc);
	position:relative;
	}
	
.span_2{
	float:right !important;
	}
	
.checkout_002{
	margin:0px 9.5%;
	float:left;
	width:27%;
	}
	
.checkout_aa1{
	width:100% !important; 
	}

.select_mnth{
	width:55% !important;
	margin-right:15px;
	}

.select_yer{
	width:38% !important; 
	}
	
.checkout_oo2_rvw{
	width:100% !important;
	}
	
.checkout_oo2_rvw p{
	width:85px !important;
	}
	
.checkout_oo2_rvw li em{
	float:left;
	font-style:normal;
	width:80px;
	color: #141414;
    float: left;
    font-size: 12px;
    line-height: 22px;
    margin-right: 60px;
    text-transform: uppercase;
	text-align:right;
	}
	
.checkout_oo2_rvw li span{
	color: #141414;
    float: left;
    font-size: 12px;
    line-height: 22px;
    margin-right: 15px;
    text-transform: uppercase;
	text-align:right;
	}
	
.checkout_lst_itm {
	margin-bottom:0 !important;
	}
	
.checkout_lst_itm p{
	text-transform:none !important;
	color:#000 !important;
	}
	
.checkout_lst_itm span{
	text-transform:none !important;
	color:#000 !important;
	text-align:right;
	}
	
.checkout_lst_itm em{
	text-transform:none !important;
	color:#000 !important;
	text-align:right;
	}

.checkout_aao_inside a{
	font-size:14px;
	color:#fff;
	text-decoration:none;
	text-transform:uppercase;
	line-height:35px;
	padding:0 25px;
	background: rgb(236,136,0); /* Old browsers */
background: -moz-linear-gradient(top, rgba(236,136,0,1) 0%, rgba(227,96,0,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(236,136,0,1)), color-stop(100%,rgba(227,96,0,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ec8800', endColorstr='#e36000',GradientType=0 ); /* IE6-9 */
	display:inline-block;
	behavior: url(PIE.htc);
	position:relative;
	float:right;
	margin-top:15px;
	}
	
.chackout_bottom_1 {
    background: none repeat scroll 0 0 #F6F6F6;
    float: right;
    padding: 15px;
    position: relative;
    width: 92%;
}

.chackout_bottom_1 ul {
    margin: 0;
    padding: 0;
}

.chackout_bottom_1 li {
    float: left;
    list-style: none outside none;
    width: 100%;
}

.chackout_bottom_1 li p {
    color: #141414;
    float: left;
    font-size: 12px;
    line-height: 22px;
    margin-right: 15px;
    text-transform: uppercase;
    width: 170px;
}

.checkout_oo2_rvw li em {
    color: #141414;
    float: left;
    font-size: 12px;
    font-style: normal;
    line-height: 22px;
    margin-right:34px;
    text-align: right;
    text-transform: uppercase;
    width: 70px;
}

.checkout_oo2_rvw li span {
    color: #141414;
    float: right;
    font-size: 12px;
    line-height: 22px;
    margin-right: 0px;
    text-align: right;
    text-transform: uppercase;
}

/*----------------------- checkout page ends -------------------------*/


/*----------------------- shopping cart page starts-------------------*/

.shopping_cart{
	overflow:hidden;
	position:relative;
	margin-bottom:15px;
	}
	
.checkout_top_heading{
	overflow:hidden;
	background:#F7F7F7;
	}
	
.checkout_top_heading ul{
	margin:0;
	padding:0;
	}
	
.checkout_top_heading li{
	list-style:none;
	color: #000;
    float: left;
    font-size: 12px;
    line-height:35px;
	text-transform:uppercase;
	text-align:center;
	padding:0 15px;
	}
	
.checkout_top_heading li:last-child{
	margin-right:0;
	}
	
.checkout_heading_1{
	float:left;
	width:55.9% !important;
	text-align:left !important;
	}
	
.checkout_heading_2{
	float:left;
	width:17.7%!important;
	}
	
.checkout_heading_2:last-child{
	float:right;
	text-align:right;
	}

.checkout_top_cntnt{
	overflow:hidden;
	border-top:none;
	}
	
.checkout_top_cntnt ul{
	margin:0;
	padding:0;
	}
	
.checkout_top_cntnt ul li{
	list-style:none;
	overflow:hidden;
	border-bottom:1px solid #ECECEC;
	}
		
.checkout_top_cntnt li li{
	list-style:none;
	color: #000;
    float: left;
    font-size: 12px;
    line-height: 22px;
	border-bottom:none;
	text-align:center;
	width:auto;
	padding:15px 15px;
	}
	
.checkout_top_cntnt li li img{
	border: 1px solid #ECECEC;
    float: left;
    margin-right: 15px;
    padding: 0;
    width: 12%;
	}
	
.checkout_top_cntnt li li:last-child{
	margin-right:0;
	}

.checkout_top_cntnt li li span{
    font-size: 13px;
    line-height: 22px;
	text-transform:uppercase;
	text-align:center;
	margin-right:15px;
	float:left;
	color:#000;
	width:220px;
	display:none;
	}
	
.checkout_top_cntnt li li a{
	color: #000;
	text-decoration:underline;
	}	
	
.checkout_top_cntnt li li a:hover{
	text-decoration:none;
	}
	
.chaechout_prdct{
	text-align:left !important;
	}
	
.checkout_heading_2 input{
	width:20px;
	display:inline-block;
	padding:5px;
	 font-size: 13px;
    line-height: 22px;
	text-align:center;
	margin-right:15px;
	color:#000;
	}
	
.checkout_heading_2 a{
	color:#fff !important;
	text-decoration:none !important;
	text-transform:uppercase;
	font-size:12px;
	background: rgb(236,136,0); /* Old browsers */
background: -moz-linear-gradient(top, rgba(236,136,0,1) 0%, rgba(227,96,0,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(236,136,0,1)), color-stop(100%,rgba(227,96,0,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(236,136,0,1) 0%,rgba(227,96,0,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ec8800', endColorstr='#e36000',GradientType=0 ); /* IE6-9 */
	display:inline-block;
	behavior: url(PIE.htc);
	height:auto !important;
	line-height:25px;
	padding:2px 0.6em;
	display:inline-block;
	}
	
.shopng_crt_btm{
    overflow: hidden;
    position: relative;
	}
	
.chackout_bottom{
	width:290px;
	float:right;
	overflow:hidden;
	position:relative;
	}
	
.chackout_bottom_1{
	width:89%;
	float:right;
	background:#f6f6f6;
	padding:15px;
	position:relative;
	}
	
.chackout_bottom_1 ul{
	margin:0;
	padding:0;
	}

.chackout_bottom_1 li{
	list-style:none;
	float:left;
	width:100%;
	margin-bottom:10px;
	}
	
.chackout_bottom_1 li:last-child{
	margin-bottom:0px;
	}
	
.chackout_bottom_1 li p{
	color: #000;
    float: left;
    font-size: 12px;
    line-height: 22px;
	text-transform:uppercase;
	margin-right:15px;
	width:170px;
	}
	
.chackout_bottom_1 li span{
	color: #000;
    float: right;
    font-size: 12px;
    line-height: 22px;
	width:auto;
	}

.chackout_bottom_2{
	background:#dcdcdc !important;
	padding:10px 15px !important;
	font-weight:bold;
	position:relative;
	}

.checkout_buttons{
	float:right;
	width:auto;
	clear:both;
	margin-top:25px;
	}
	
.checkout_buttons ul{
	margin:0;
	padding:0;
	}
	
.checkout_buttons li{
	list-style:none;
	float:left;
	}
	
.checkout_buttons li a{
	float:left;
	text-decoration:none;
	}
</style>
@endsection
@section('tour')
<div class="bgsilver clearfix">
    <div id="wrapper" class="container_24 bgwhite padding_30 logindiv register_wrapper">
<div class="darkgray title fan-top"><strong><span class="heading darkgreen">Checkout</span></strong></div>
<div class="bggray padding_20 brsilver_topwhite login_inner">


<div id="checkout">
<div class="check">  
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payPalForm"  name="payform">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="hbawab@magiclogix.com">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="return" value="{{URL::to('success')}}">
						<input type="hidden" name="cancel_return" value="{{URL::to('cancel')}}"/>
						<input type="hidden" name="notify_url" value="{{URL::to('success')}}"/>
						<input type="hidden" name="custom" value="" id="customvalue">
						<input type="hidden" name="item_name" value="Plan {{$plan->plan_name}}" id="projectvalue">
						<input type="hidden" name="item_number" value="11">
						<input type="hidden" name="amount" value="{{$plan->plan_price}}">
				        <input type="image" style="float:right;height: 100%;width: 10%;" src="{{URL::to('/')}}/images/checkout.png" name="submit">
					</form>	
					 </div>
  <div class="checkout">
    
    <div class="shopping_cart">
          <div class="checkout_top_heading">
                  <ul>
                    <li class="checkout_heading_1">Description</li>
                    <li class="checkout_heading_2">Quantity</li>
                    <li class="checkout_heading_2">Price</li>
                  </ul>
                </div>
              <div class="checkout_top_cntnt">
                  <ul>
                   
                     <li>
                        <ul>
                    	  <li class="checkout_heading_1 chaechout_prdct"><span>Product Name</span><p>{{$plan->plan}}: {{$plan->plan_description}}</p></li>
                   	 	  <li class="checkout_heading_2"><span>Quantity</span>1</li>
                   		  <li class="checkout_heading_2"><span>Price</span>${{$plan->plan_price}}</li>
                  	    </ul>
                    </li>
                  </ul>
                </div>
           </div>
           
           <div class="shopng_crt_btm">
               
               <div class="chackout_bottom">
                <div class="chackout_bottom_1">
                  <ul>
                    <li>
                      <p>Product Total</p>
                      <span>${{$plan->plan_price}}</span>
                    </li>
                    <li>
                      <p>Tax</p>
                      <span>$0.00</span>
                    </li>
                  </ul>
                </div>
                 <div class="chackout_bottom_1 chackout_bottom_2">
                  <ul>
                    <li>
                      <p>Total</p>
                      <span>${{$plan->plan_price}}</span>
                    </li>
                  </ul>
                </div>
              </div>
              
              <div class="checkout_buttons">
                <ul>
           <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payPalForm"  name="payform">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="hbawab@magiclogix.com">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="return" value="{{URL::to('success')}}">
						<input type="hidden" name="cancel_return" value="{{URL::to('cancel')}}"/>
						<input type="hidden" name="notify_url" value="{{URL::to('success')}}"/>
						<input type="hidden" name="custom" value="" id="customvalue">
						<input type="hidden" name="item_name" value="Plan {{$plan->plan_name}}" id="projectvalue">
						<input type="hidden" name="item_number" value="11">
						<input type="hidden" name="amount" value="{{$plan->plan_price}}">
				        <input type="image" src="{{URL::to('/')}}/images/paypal1.png" name="submit">
					</form>	

                </ul>
              </div>
                          
           </div>
    
  </div>
</div>






</div>
</div>
</div>
@endsection



</body>
</html> 
