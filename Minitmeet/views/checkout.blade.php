@extends('layout/checkout')
@section('title')
Checkout
@endsection
@section('content')
 <style>
	 .heading {
		background: url("../img/direction.png") no-repeat scroll right center transparent;
		font-size: 26px;
		font-weight: bold;
		padding-right: 27px;
	    }
        fieldset {
            overflow: auto;
            border: 0;
            margin: 0;
            padding: 0; }

        fieldset div {
            float: left; }

        fieldset.centered div {
            text-align: center; }

        label {
            color: #183b55;
            display: block;
          }

        label img {
            display: block;
            margin-bottom: 5px; }

       .common {
            border: 1px solid #bfbab4;
            margin: 0 4px 8px 0;           
            color: #1e1e1e;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: inset 0px 5px 5px #eee;
            -moz-box-shadow: inset 0px 5px 5px #eee;
            box-shadow: inset 0px 5px 5px #eee;
            width:300px; }
          .custom {
            border: 1px solid #bfbab4;
            margin: 0 4px 8px 0;           
            color: #1e1e1e;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: inset 0px 5px 5px #eee;
            -moz-box-shadow: inset 0px 5px 5px #eee;
            box-shadow: inset 0px 5px 5px #eee;
            width:148px; }
        .submit {			
			height: 41px;
            display: block;
            background-color: #76b2d7;
            border: 1px solid #766056;
            color: #3a2014;
            margin: 13px 0;
            padding: 8px 16px;
            -webkit-border-radius: 12px;
            -moz-border-radius: 12px;
            border-radius: 12px;
            font-size: 14px;
            -webkit-box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75);
            -moz-box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75);
            box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75); }
        </style>
<span class="heading darkgreen">Checkout</span>
<!-- Begin PayPal Button -->
@if($plan=="B")
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payPalForm"  name="payform">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="hbawab@magiclogix.com">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="return" value="{{URL::to('success')}}">
						<input type="hidden" name="cancel_return" value="{{URL::to('cancel')}}"/>
						<input type="hidden" name="notify_url" value="{{URL::to('success')}}"/>
						<input type="hidden" name="custom" value="" id="customvalue">
						<input type="hidden" name="item_name" value="Plan B" id="projectvalue">
						<input type="hidden" name="item_number" value="11">
						<input type="hidden" name="amount" value="29.99">
				        <input type="image" src="https://www.sandbox.paypal.com/en_GB/i/btn/btn_paynowCC_LG.gif" name="submit">
					</form>	


</form>
@endif
@if($plan=="C")

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payPalForm"  name="payform">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="hbawab@magiclogix.com">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="return" value="{{URL::to('success')}}">
						<input type="hidden" name="cancel_return" value="{{URL::to('cancel')}}"/>
						<input type="hidden" name="notify_url" value="{{URL::to('success')}}"/>
						<input type="hidden" name="custom" value="" id="customvalue">
						<input type="hidden" name="item_name" value="Plan C" id="projectvalue">
						<input type="hidden" name="item_number" value="21">
						<input type="hidden" name="amount" value="99.99">
				        <input type="image" src="https://www.sandbox.paypal.com/en_GB/i/btn/btn_paynowCC_LG.gif" name="submit">
					</form>	



@endif

<br> @if($success)
    <div class="signupAlert alert alert-success">
        <h2>{{$success }}</h2>
    </div>
    @endif
  
<h2>Pay with (Authorise.net)</h2>
        <form method="post" action="{{URL::to('checkout')}}/{{$plan}}" id="checkout_form">       
             
        <label for="authorizenet_cc_type" class="required"><em>*</em>Credit Card Type</label>      
            <select autocomplete="off" class="common"  name="type" required >
                <option value="">--Please Select--</option>
                            <option selected="selected" value="AE">American Express</option>
                            <option value="VI">Visa</option>
                            <option value="MC">MasterCard</option>
                            <option value="DI">Discover</option>
                        </select>
        
        <label for="authorizenet_cc_number" class="required"><em>*</em>Credit Card Number</label>       
            <input autocomplete="off" name="x_card_num" type="text" class="common" required >      
    
        <label for="authorizenet_expiration" class="required"><em>*</em>Expiration Date</label>       
                <select autocomplete="off" class="custom" name="month" required>
                                    <option value="" selected="selected">Month</option>
                                    <option value="01">01 - January</option>
                                    <option value="02">02 - February</option>
                                    <option value="03">03 - March</option>
                                    <option value="04">04 - April</option>
                                    <option value="05">05 - May</option>
                                    <option value="06">06 - June</option>
                                    <option value="07">07 - July</option>
                                    <option value="08">08 - August</option>
                                    <option value="09">09 - September</option>
                                    <option value="10">10 - October</option>
                                    <option value="11">11 - November</option>
                                    <option value="12">12 - December</option>
                                    </select>
                         <select autocomplete="off" class="custom" name="year"> 
                                     <?php
										   $yearRange = 20;
										   $thisYear = date('Y');
										   $startYear = ($thisYear + $yearRange);
										 
										   foreach (range($thisYear, $startYear) as $year)
										   {
											  if ( $year == $thisYear) {
												 print '<option value="'.substr($year,-2).'" selected="selected">' . $year . '</option>';
											  } else {
												 print '<option value="'.substr($year,-2).'">' . $year . '</option>';
											  }
										   }
										?>
                        </select>
          <input type="submit" class="submit" value="Pay Now">             
      </form>

<!-- End PayPal Button -->
@endsection
