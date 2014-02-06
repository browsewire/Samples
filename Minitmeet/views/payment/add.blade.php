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
<form method="POST" action="{{URL::to('admin/payment/new')}}"  >

   <div class="group fixed">
								<label>Payer Firstname</label>
								<input name="firstname" type="text" placeholder="Enter Payer Firstname" value="" />
								</div>
		                          <div class="group fixed">
								<label> Payer Lastname</label>
								<input name="lastname" type="text" placeholder="Enter Payer Lastname" value="" />
								
								</div>
		                      <div class="group fixed">
								<label> Payer Email</label>
								<input name="email" type="text" placeholder="Enter Payer Email" value="" />
	                           </div>
				             
				             <div class="group fixed">
								<label>Transaction ID</label>
								<input name="transaction_id" type="text" placeholder="Enter Transaction ID" value="" />
	                           </div>
	                            <div class="group fixed">
								<label>Amount</label> 
								<select name="amount">
									<option value="" >Select Amount</option>
								 <?php $plan = DB::table('plan')->where('plan_name','!=','A')->get(array('plan_price'));
								     foreach($plan as $price){?>
								    <option value="{{$price->plan_price}}" >${{$price->plan_price}}</option>
								    <?php }
								      ?>					
								</select>	
	                          </div>
	                        <div class="group fixed">
								<label>Medium</label> 
								<select name="medium">
									<option value="" >Select Plan</option>
									<option value="authorise">Authorise</option>
									<option value="paypal">Paypal</option>								
								</select>					
					      </div>
					    <input type="submit" value="Add Payment"  name="submit" class="button-white">							
						</form>
						</div>
@endsection
