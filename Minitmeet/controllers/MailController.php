<?php
// application/controllers/account.php
class MailController extends BaseController
{
public function getmailone(){	
	return View::make('admin.mail');
}

public function getmailmany(){
	
	return View::make('admin.many');
}
public function postmailmany(){
	
		
	 $rules = array(    	
    	'plan'			     =>  'required',
    	'subject'            =>  'required',
    	'message'            =>  'required',
    	);
	$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('admin/mail/many')->withInput()->withErrors($v);
			}
			else{
				print_r($_POST);
				$message=Input::get('message');			
				$mail =	Mail::send('emails.mail', array('mesage'=>$message), function($message)
				{  
					$data= DB::table('users')->where('plan','=',Input::get('plan'))->lists('email');					
					$message->to($data);				
					$message->subject(Input::get('subject'));				
		    });				
	return Redirect::to('admin');				
			}
	
}
public function postmailone(){
		
	 $rules = array(    	
    	'recepient'			=> 'required',
    	'subject'           =>  'required',
    	'message'            => 'required',
    	);
	$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('admin/mail/one')->withInput()->withErrors($v);
			}
			else{
			
			    $message=Input::get('message');			
				$mail =	Mail::send('emails.mail', array('mesage'=>$message), function($message)
				{  
					$email= Input::get('recepient');				
					$e = explode(",", $email);
					$message->to($e);				
					$message->subject(Input::get('subject'));
				
				});
				
	return Redirect::to('admin');
	}
      
  }

}


?>
