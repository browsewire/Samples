<?php

class UserController extends BaseController
{
	public function getuseredit($id){
		 $data=DB::table('users')->where('id','=',$id)->get();
	     return View::make('user.edit')->with('data',$data);
}
	public function getuserupdate($id){
	 DB::table('users')->where('id','=',$id)->update(Input::all());
	 $data=DB::table('users')->paginate(10);
	 return View::make('admin.user')->with('data',$data);
	
	}
	public function getuseradd(){
		return View::make('user.add');
	}
	public function getuserall(){
		$data=DB::table('users')->paginate(10);
	  return View::make('admin.user')->with('data',$data);
		
	}
	public function postusernew(){
		$userdata = array(
    	'first_name'	=> Input::get('first_name'),
    	'last_name'		=> Input::get('last_name'),
    	'email'			=> Input::get('email'),
        'username'      => Input::get('username'),
		'password'      => Hash::make(Input::get('password')),
		'plan'		    => input::get('plan'),
		'bgcolor'       =>"58,104,210",
		'fontcolor'     =>"255,255,255",
		'logo'          =>"http://minitmeet.com/img/logo.png",		
        'company_name'	=> Input::get('company_name'),
        'status'        =>Input::get('status')     
      
	);
    $rules = array(
    	'first_name'	=> 'required',
    	'last_name'		=> 'required',
    	'email'			=> 'required|min:3|max:32|Unique:users,email',
        'username'      => 'Required|Min:3|Max:80|Regex:/^([a-z0-9- ])+$/i|Unique:users',
		'password'      => 'required|min:6|max:32',
		'company_name'  => 'required',
		'plan'          => 'required',
		'status'        => 'required', 		
	);
	
	$input = Input::all();
	  $v = Validator::make($input, $rules);
			if( $v->fails() ){
				
			    return Redirect::to('admin/user/add')->withInput(Input::except('password'))->withErrors($v);
			}
			else{
				DB::table('users')->insert($userdata);
				$data=DB::table('users')->paginate(10);
	            return View::make('admin.user')->with('data',$data);
			}	
	}
	
  public function getdelete($id){
	
	  DB::table('users')->where('id','=',$id)->delete();
	  $data=DB::table('users')->paginate(10);
	  return Redirect::back();
	  
  }
  
  public function getplanlist(){
	  
	   $data= DB::table('plan')->get();	  
	   return View::make('cms.plan')->with('data',$data);
  }
  
  public function getplanadd(){	  
	return View::make('cms.planadd');  
  }
  public function postplancreate(){
	  print_r($_POST); 
	  
	  $rules = array(
    	'plan_name'            => 'required',
    	'plan_price'		   => 'required',
    	'plan_description'	   => 'required',
        'plan_subdescription'  => 'required',			
	  );
	
	$input = Input::all();
	  $v = Validator::make($input, $rules);
			if( $v->fails() ){				
			    return Redirect::to('admin/plan/add')->withInput(Input::get())->withErrors($v);
			}
			else{
				DB::table('plan')->insert(Input::all());
				$data=DB::table('plan')->get();
	            return View::make('cms.plan')->with('data',$data);
			}	 
	  
  }
  
  public function getplanedit($id){
	 
	  $data= DB::table('plan')->where('id','=',$id)->get();
	  return View::make('cms.planedit')->with('data',$data);
  }
  public function getplanupdate($id){
	 
	  $data=DB::table('plan')->where('id','=',$id)->update(Input::all());
	  $data=DB::table('plan')->get();
	  return View::make('cms.plan')->with('data',$data);
	  
  }
  public function deleteplan(){
	  DB::table('plan')->delete();
	  return Redirect::to('/admin');
	  
  }
  
  public function deleteoneplan($id){
	  
	  $data= DB::table('plan')->where('id','=',$id)->delete();
	   $data=DB::table('plan')->get();
	  return View::make('cms.plan')->with('data',$data);
	  
	  
  }
  public function get_setting(){
	  
	 $id   = Auth::user()->id; 
	 $info = DB::table('users')->where('id',$id)->first();
	 //$planinfo = DB::table('users')->where('id',$id)->get(array('plan'));	 
	 $payinfo= DB::table('transaction_id')->orderBy('id', 'desc')->where('user_id',$id)->get();	  
	 return View::make('account.setting')->with('info',$info)->with('payinfo',$payinfo);
	  
  }
  public function getform($id){
	  $info = DB::table('users')->where('id',$id)->first();	  
	 return View::make('account.editinfo')->with('info',$info);
	  
  }
  public function postform($id){
	    $data=DB::table('users')->where('id','=',$id)->update(Input::all());
	  return Redirect::to('account/setting');
	  
  }
  
  
}


?>
