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
  

<form method="POST" action="{{URL::to('admin/order/update')}}/{{$data->id}}"  >

   <div class="group fixed">
								<label>Payer Email</label>
								<input name="payer_email" type="text" placeholder="Enter Payer Firstname" value="{{$data->payer_email}}" />
								</div>
		                          <div class="group fixed">
								<label> Transaction ID</label>
								<input name="transaction_id" type="text" placeholder="Enter Payer Lastname" value="{{$data->transaction_id}}" />								
								</div>
	                        <div class="group fixed">
								<label>Medium</label> 
								<select name="txn_type">
									<option value="" >Select Plan</option>
									@if($data->txn_type=="paypal")
									<option value="authorise">Authorise</option>
									<option value="paypal" selected>Paypal</option>	
									@endif
									@if($data->txn_type=="authorise")	
									<option value="authorise" selected>Authorise</option>
									<option value="paypal" >Paypal</option>
									@endif
									@if($data->txn_type=="")	
									<option value="authorise">Authorise</option>
									<option value="paypal" >Paypal</option>
									@endif							
								</select>					
					      </div>
					      <div class="group fixed">
								<label>Select status</label> 
								<select name="payment_status">
									<option value="" >Select Status</option>
									@if($data->payment_status=="Pending")
									<option value="Pending" selected>Pending</option>
									<option value="Partial">Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif
									@if($data->payment_status=="Partial")	
									<option value="Pending" >Pending</option>
									<option value="Partial" selected>Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif	
									@if($data->payment_status=="Received")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received" selected>Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif		
									@if($data->payment_status=="Refunded")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded" selected>Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif		
									@if($data->payment_status=="Declined")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined" selected>Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif		
									@if($data->payment_status=="Canceled")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled" selected>Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif
									@if($data->payment_status=="Error")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled" >Canceled</option>
									<option value="Error" selected>Error</option>
									<option value="Backorder" >Backorder</option>		
									@endif	
									@if($data->payment_status=="Backorder")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder" selected>Backorder</option>		
									@endif
									@if($data->payment_status=="")	
									<option value="Pending" >Pending</option>
									<option value="Partial" >Partial</option>
									<option value="Received">Received</option>
									<option value="Refunded">Refunded</option>
									<option value="Declined">Declined</option>
									<option value="Canceled">Canceled</option>
									<option value="Error" >Error</option>
									<option value="Backorder">Backorder</option>		
									@endif
									@if($data->payment_status=="1")	
									<option value="1" selected >Approved</option>
										
									@endif									
								</select>					
					      </div>
					      
					    <input type="submit" value="Edit Payment"   class="button-white">							
						</form>
					
					
						</div>
				@endsection		

