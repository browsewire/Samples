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
<form method="post" action="{{URL::to('admin/user/update')}}/{{$data[0]->id}}" >
@foreach($data as $value)
                               <div class="group fixed">
								 <label>Firstname</label>
								   <input name="first_name" type="text" value="{{$value->first_name}}" />
								</div>
		                        <div class="group fixed">
								  <label>Lastname</label>
								  <input name="last_name" type="text" value="{{$value->last_name}}" />								
								</div>
		                      <div class="group fixed">
								<label>Email</label>
								<input name="email" type="text" value="{{$value->email}}" />
	                          </div>
				             
					       <div class="group fixed">
								<label>Company</label>
								<input name="company_name" type="text" value="{{$value->company_name}}" />
	                       </div>
	                        <div class="group fixed">
								<label>Plan</label> 
								<select name="plan">
									<option>Select Plan</option>
									@if($value->plan=="A")
										<option value="A" selected>Plan A</option>
										<option value="B" >Plan B</option>
										<option value="C" >Plan C</option>
									@endif
									@if($value->plan=="B")
										<option value="A" >Plan A</option>
										<option value="B" selected>Plan B</option>
										<option value="C" >Plan C</option>
									@endif
									@if($value->plan=="C")
										<option value="A" >Plan A</option>
										<option value="B" >Plan B</option>
										<option value="C" selected>Plan C</option>
									@endif
									@if(empty($value->plan))
									    <option value="A" >Plan A</option>
										<option value="B" >Plan B</option>
										<option value="C" >Plan C</option>
									@endif
								</select>					
					      </div>
					      
					      <div class="group fixed">
								<label>Add Role</label> 
								<select name="status">
									<option value="" >Select Role</option>
									@if($value->status=="0")
									<option value="1">Admin</option>
									<option value="0" selected>User</option>
									@endif
									@if($value->status=="1")
									<option value="1" selected>Admin</option>
									<option value="0">User</option>
									@endif									
								</select>		
					      </div>
					   <input type="submit" value="Update"  class="button-white">		
							
						</form>
					@endforeach	
						
						</div>
@endsection
