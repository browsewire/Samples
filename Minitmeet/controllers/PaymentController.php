<?php
// application/controllers/account.php
class PaymentController extends BaseController
{	
public function selectplan($id){
	Session::put('plan',$id);
	return Redirect::to('register');
}

public function onepagecehckout(){
	$plan_info =DB::table('plan')->where('plan_name',Session::get('get_plan'))->first();
	return View::make('onepage')->with('plan',$plan_info);	
}

public function get_login($plan){	
	if($plan=='A'){
	 $userdata = array(
    	'first_name'	=> Input::get('first_name'),
    	'last_name'		=> Input::get('last_name'),
    	'email'			=> Input::get('email'),
        'username'      => Input::get('username'),
		'password'      => Hash::make(Input::get('password')),
		 'address'      => Input::get('address'),
		  'city'        => Input::get('city'),
		 'state'        => Input::get('state'),
		 'zipcode'      => Input::get('zipcode'),
		 'country'		=> Input::get('country'),
		'bgcolor'       =>"58,104,210",
		'fontcolor'     =>"255,255,255",
		'logo'          =>"http://minitmeet.com/img/logo.png",		
        'company_name'	=> Input::get('company_name')
      /*  'industry'		=> Input::get('industry'),
        'job_title'		=> Input::get('job_title')*/
	);
    $rules = array(
    	'first_name'	=> 'required',
    	'last_name'		=> 'required',
    	'email'			=> 'required|min:3|max:32|Unique:users,email',
        'username'      => 'Required|Min:3|Max:80|Regex:/^([a-z0-9- ])+$/i|Unique:users',
		'password'      => 'required|min:6|max:32',
		'captcha'       => 'required',
		'address'       => 'required',		
		'state'         => 'required',		
		'country'       => 'required',	
		'zipcode'       => 'required',
		'company_name'	=> 'required|alpha_num',				
	);	
	$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('register')->withInput(Input::except('password'))->withErrors($v);
			}
			else{
			   
	$data=$userdata;
	$pass=Input::get('password');	
	DB::table('users')->insert($data);	
	DB::table('users')->where('email',$data['email'])->update(array('plan'=>$plan ));
	$mail =	Mail::send('emails.message', array('data'=>$data ,'plan'=>$plan ,'pass'=>$pass), function($message)
	     {
			$data=Session::get('data');	
			$message->to($data['email'])->subject('Minitmeet');
				});
	return Redirect::to('login')->with('success','You Have been Registered Succesfully'); 
   }
}
	elseif($plan=='B' or $plan=='C'){		
    $rules = array(
    	'payment_type'	=> 'required',    				
	);	
		$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('register')->withInput(Input::except('password'))->withErrors($v);
			}
			else{
				
if($_POST['payment_type']=="1"){
	
		$userdata = array(
    	'first_name'	=> Input::get('first_name'),
    	'last_name'		=> Input::get('last_name'),
    	'email'			=> Input::get('email'),
        'username'      => Input::get('username'),
		'password'      => Hash::make(Input::get('password')),
		 'address'      => Input::get('address'),
		'city'          => Input::get('city'),
		'state'         => Input::get('state'),
		'zipcode'       => Input::get('zipcode'),
		'country'		=> Input::get('country'),
		'bgcolor'       =>"58,104,210",
		'fontcolor'     =>"255,255,255",
		'logo'          =>"http://minitmeet.com/img/logo.png",		
        'company_name'	=> Input::get('company_name')
      /*  'industry'		=> Input::get('industry'),
        'job_title'		=> Input::get('job_title')*/
	);
    $rules = array(
    	'first_name'	=> 'required',
    	'last_name'		=> 'required',
    	'email'			=> 'required|min:3|max:32|Unique:users,email',
    	'address'       => 'required',		
		'state'         => 'required',		
		'country'       => 'required',	
		'zipcode'       => 'required',
        'username'      => 'Required|Min:3|Max:80|Regex:/^([a-z0-9- ])+$/i|Unique:users',
		'password'      => 'required|min:6|max:32',		
		'company_name'	=> 'required|alpha_num',				
	);	
		$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('register')->withInput(Input::except('password'))->withErrors($v);
			}else{
				 Session::put('get_plan',$plan);
				 Session::put('data',$userdata); 
				return Redirect::to('onepagecheckout');
			}
			
	}
	 if($_POST['payment_type']=="2"){
		 $userdata = array(
    	'first_name'	=> Input::get('first_name'),
    	'last_name'		=> Input::get('last_name'),
    	'email'			=> Input::get('email'),
        'username'      => Input::get('username'),
		'password'      => Hash::make(Input::get('password')),
		'address'      => Input::get('address'),
		'city'          => Input::get('city'),
		'state'         => Input::get('state'),
		'zipcode'       => Input::get('zipcode'),
		'country'		=> Input::get('country'),
		'bgcolor'       =>"58,104,210",
		'fontcolor'     =>"255,255,255",
		'logo'          =>"http://minitmeet.com/img/logo.png",		
        'company_name'	=> Input::get('company_name')
      /*  'industry'		=> Input::get('industry'),
        'job_title'		=> Input::get('job_title')*/
	);
    $rules = array(
    	'first_name'	=> 'required',
    	'last_name'		=> 'required',
    	'email'			=> 'required|min:3|max:32|Unique:users,email',
    	'address'       => 'required',		
		'state'         => 'required',		
		'country'       => 'required',	
		'zipcode'       => 'required',
        'username'      => 'Required|Min:3|Max:80|Regex:/^([a-z0-9- ])+$/i|Unique:users',
		'password'      => 'required|min:6|max:32',		
		'company_name'	=> 'required|alpha_num',
		'card_number'	=> 'required',		
		'month'     	=> 'required', 						
	);	
		$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('register')->withInput(Input::except('password'))->withErrors($v);
	}
	 else
	  {			
		 $card_num = Input::get('card_number');		
		 $month = Input::get('month');
		 $year  = Input::get('year');		
		 $type  = Input::get('card_type');
		 $plan  = Session::get('plan'); 
		 $am = DB::table('plan')->where('plan_name',Session::get('plan'))->first();
		 $amount = $am->plan_price;	
		 $data=$userdata;
	     $pass=Input::get('password');	 
		require_once 'anet_php_sdk/AuthorizeNet.php'; // Make sure this path is correct.
		$transaction = new AuthorizeNetAIM('9Hs3U7ePV', '7Fjj4kLu39LL62V2');
		$transaction->amount = $amount;
		$transaction->card_num = $card_num;
		$transaction->exp_date = $month."/".$year;
	    //$transaction->bank_aba_code = $type;		 
		$response = $transaction->authorizeAndCapture();
		if ($response->approved){
			
			DB::table('users')->insert($data);	
			DB::table('users')->where('email',$data['email'])->update(array('plan'=>$plan ));
			$id = DB::table('users')->where('email',$data['email'])->get(array('id'));			
			DB::table('transaction_id')->insert(array('user_id'=>$id[0]->id, 'transaction_id'=>$response->transaction_id,'payer_email'=>$data['email'],'txn_type'=>"authorise",'payment_status'=>$response->response_code,'address'=>$data['address'],'zipcode'=>$data['zipcode'],'state'=>$data['state'],'country'=>$data['country']));
		    DB::table('transaction_list')->insert(array('transaction_id'=>$response->transaction_id,'amount'=>$amount,'email'=>$data['email'],'medium'=>"authorise",'firstname'=>$data['first_name'],'lastname'=>$data['last_name'] ));
		    $mail =	Mail::send('emails.message', array('data'=>$data ,'plan'=>$plan ,'pass'=>$pass), function($message)
	     {
			 $message->to(Input::get('email'))->subject('Minitmeet');
				});
		    Session::flush(); 
			$responsetext= "Transaction Done.Your transaction Id is: $response->transaction_id.Enter Username and password to Login";
		    //echo $responsetext; die();
		    return Redirect::to('login')->with('success',$responsetext);		  
		} 
		else
		 {
		  return Redirect::to('register')->with('success',$response->error_message)->with('plan',$plan);
	    } 
				
			}
		 
	      }
     	}
	 }
 }
		
    

          
   public function checkout($plan){	 
		
	    
	}       
    public function success(){
			$raw_post_data = file_get_contents('php://input');
			//print_r($raw_post_data);		
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
				 $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
					$value = urlencode(stripslashes($value)); 
			   } else {
					$value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}
			// STEP 2: Post IPN data back to paypal to validate
			$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			if( !($res = curl_exec($ch)) ) {
				// error_log("Got " . curl_error($ch) . " when processing IPN data");
				curl_close($ch);
				exit;
			}
			curl_close($ch);
			// STEP 3: Inspect IPN validation result and act accordingly

			if (strcmp($res, "VERIFIED") == 0) {			
				$item_name = $_POST['item_name'];
				$item_number = $_POST['item_number'];
				$payment_status = $_POST['payment_status'];
				$payment_amount = $_POST['mc_gross'];
				$payment_currency = $_POST['mc_currency'];
				$txn_id = $_POST['txn_id'];
				$receiver_email = $_POST['receiver_email'];
				$payer_email = $_POST['payer_email'];
				$address= $_POST['address_street'];
				$zipcode = $_POST['address_zip'];
				$state = $_POST['address_state'];
				$city= $_POST['address_city'];
				$country = $_POST['address_country']; 
 				// <---- HERE you can do your INSERT to the database				
				$plan = Session::get('get_plan');
				$data=Session::get('data');
				if($data){
					$pass=Session::get('pass');			
				DB::table('users')->insert($data);	
				DB::table('users')->where('email',$data['email'])->update(array('plan'=>$plan ));
				$id = DB::table('users')->where('email',$data['email'])->get(array('id'));			
				DB::table('transaction_id')->insert(array('user_id'=>$id[0]->id, 'transaction_id'=>$txn_id,'payer_email'=>$payer_email,'txn_type'=>"paypal",'payment_status'=>$payment_status,'address'=>$address,'state'=>$state,'zipcode'=>$zipcode,'country'=>$country));
			    DB::table('transaction_list')->insert(array('transaction_id'=>$txn_id,'amount'=>$payment_amount,'email'=>$payer_email,'medium'=>"paypal",'firstname'=>$data['first_name'],'lastname'=>$data['last_name'] ));
				$mail =	Mail::send('emails.message', array('data'=>$data ,'plan'=>$plan ,'pass'=>$pass), function($message)
				{
					$data=Session::get('data');	
					$message->to($data['email'])->subject('Minitmeet');
				});
				Session::flush(); 
				$responsetext= "Transaction Done.Your transaction Id is: $txn_id.Enter Username and password to Login";
				return View::make('login')->with('success',$responsetext);
			    }
			   else{
				    return View::make('login')->with('success',"Provide Your Detail first");
			    }
			  }
			  else if (strcmp ($res, "INVALID") == 0){
				$responsetext= "Transaction Invalid";
				return View::make('login')->with('success',$responsetext);
			}
}
	
      public function cancel(){		        
				return View::make('index');		
	  }
	  
	 public function getpaymentadd(){
		return View::make('payment.add'); 
	 } 
	 
	 public function postpaymentadd(){
	$userdata = array(
    	'firstname'	    => Input::get('firstname'),
    	'lastname'		=> Input::get('lastname'),
    	'email'			=> Input::get('email'),
        'transaction_id'=> Input::get('transaction_id'),
        'amount'        => Input::get('amount'),
		'medium'        => Input::get('medium')
	);
    $rules = array(
    	'firstname'	=> 'required',
    	'lastname'		=> 'required',
    	'email'			=> 'required|min:3|max:32',
    	'transaction_id'=> 'required',
    	'amount'        => 'required',
    	'medium'        => 'required',
	);	
	$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('admin/payment/add')->withInput()->withErrors($v);
			}
			else{
				DB::table('transaction_list')->insert($userdata);
				 $data=DB::table('transaction_list')->where('status','=','0')->paginate(10);
	             return View::make('admin.order')->with('data',$data);
			}
		 
		 
	 }
	 public function getpaymentedit($id){
		 $data= DB::table('transaction_list')->where('id','=',$id)->paginate(10);		
		 return View::make('payment.edit')->with('data',$data);
		 
		 
	 }
	 public function postpaymentedit($id){
		 $userdata = array(
    	'firstname'	    => Input::get('firstname'),
    	'lastname'		=> Input::get('lastname'),
    	'email'			=> Input::get('email'),
        'transaction_id'=> Input::get('transaction_id'),
        'amount'        => Input::get('amount'),
		'medium'        => Input::get('medium')
	);
   
	  DB::table('transaction_list')->where('id','=',$id)->update($userdata);
	  $data=DB::table('transaction_list')->where('status','=','0')->paginate(10);
	  return View::make('admin.order')->with('data',$data);
	}
	public function postpaymentremove($id){
		
		DB::table('transaction_list')->where('id','=',$id)->update(array('status'=>1));
		 $data=DB::table('transaction_list')->where('status','=','0')->paginate(10);
	  return View::make('admin.order')->with('data',$data);
		
		
	}
	public function getpayment(){
		$data=DB::table('transaction_list')->where('status','=','0')->paginate(10);
	  return View::make('admin.order')->with('data',$data);
	}

}
