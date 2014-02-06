@extends('layout/admin')

@section('title')
Admin Dashboard
@endsection
<style>


form .group input {
	
	width:25%!important;
	}
</style>
@section('content')
<div class="panel">
  @include('error.validation')
  
  @foreach($data as $value)
  
<form method="POST" action="{{URL::to('admin/payment/update')}}/{{$value->id}}"  >

   <div class="group fixed">
  
  
								<label>Payer Firstname</label>
								<input name="firstname" type="text" placeholder="Enter Payer Firstname" value="{{$value->firstname}}" />
								</div>
		                          <div class="group fixed">
								<label> Payer Lastname</label>
								<input name="lastname" type="text" placeholder="Enter Payer Lastname" value="{{$value->lastname}}" />
								
								</div>
		                      <div class="group fixed">
								<label> Payer Email</label>
								<input name="email" type="text" placeholder="Enter Payer Email" value="{{$value->email}}" />
	                           </div>
				             
				             <div class="group fixed">
								<label>Transaction ID</label>
								<input name="transaction_id" type="text" placeholder="Enter Transaction ID" value="{{$value->transaction_id}}" />
	                           </div>
	                            <div class="group fixed">
								<label>Amount</label> 
								<select name="amount">
									<option value="" >Select Amount</option>				  
							
											<option value="{{$value->amount}}" selected>${{$value->amount}}</option>
											 <?php 
								   $plan = DB::table('plan')->where('plan_name','!=','A')->where('plan_price','!=',$value->amount)->get(array('plan_price')); 
								  foreach($plan as $price){ ?>
											<option value="{{$price->plan_price}}" >${{$price->plan_price}}</option>
											<?php } ?>
											 
								      		
								</select>	
	                          </div>
	                        <div class="group fixed">
								<label>Medium</label> 
								<select name="medium">
									<option value="" >Select Plan</option>
									@if($value->medium=="paypal")
									<option value="authorise">Authorise</option>
									<option value="paypal" selected>Paypal</option>	
									@endif
									@if($value->medium=="authorise")	
									<option value="authorise" selected>Authorise</option>
									<option value="paypal" >Paypal</option>
									@endif						
								</select>					
					      </div>
					    <input type="submit" value="Edit Payment"  class="button-white">							
						</form>
						@endforeach
						</div>
						
@endsection
