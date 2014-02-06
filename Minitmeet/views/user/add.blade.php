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
<form method="POST" action="{{URL::to('admin/user/new')}}"  >

   <div class="group fixed">
								<label>Firstname</label>
								<input name="first_name" type="text" placeholder="Enter Firstname" value="" />
								</div>
		                          <div class="group fixed">
								<label>Lastname</label>
								<input name="last_name" type="text" placeholder="Enter Lastname" value="" />
								
								</div>
		                      <div class="group fixed">
								<label>Email</label>
								<input name="email" type="text" placeholder="Enter Email" value="" />
	                           </div>
				             
				             <div class="group fixed">
								<label>Username</label>
								<input name="username" type="text" placeholder="Enter Username" value="" />
	                           </div>
	                          <div class="group fixed">
								<label>Password</label>
								<input name="password" type="password" placeholder="Enter Password" value="" />
	                          </div>
					       <div class="group fixed">
								<label>Company</label>
								<input name="company_name" type="text" placeholder="Enter Company Name" value="" />
	                       </div>
	                        <div class="group fixed">
								<label>Plan</label> 
								<select name="plan">
									<option value="" >Select Plan</option>
									<option value="A">Plan A</option>
									<option value="B">Plan B</option>
									<option value="C">Plan C</option>
								</select>					
					      </div>
					       <div class="group fixed">
								<label>Add Role</label> 
								<select name="status">
									<option value="" >Select Role</option>
									<option value="1">Admin</option>
									<option value="0">User</option>									
								</select>					
					      </div>
					    <input type="submit" value="Add User"  name="submit" class="button-white">		
							
						</form>
						</div>
@endsection
