<?php

Route::group(array('domain' => '{url}.minitmeet.com'), function()
    { $url =  explode('.', $_SERVER['HTTP_HOST']);
if(count($url) == 3){	
	 $name= $url[0];
	 $test = DB::table('users')->where('company_name',$name)->count();

     if($test < 1){
			echo "fail";
			return View::make('error.404'); die();
          }
     else {
	Route::get('login', function(){

  return View::make('login')->with('success','hello');
 
});
}
} else{
   
  Route::get('error', function(){
  return View::make('error.404'); die();
   
});
}   
});
Route::get('/', function()
{
	return View::make('index');
});

Route::get('login', function() {	  
	    return View::make('login')->with('success','Enter Username Password To Login');
	});

/* Getting respons form http://url/faq */
	Route::get('faq', function() {
	    Auth::logout();
	    $faq = DB::table('faq')->get();
	    return View::make('faq')->with('data',$faq);
	});

/* Getting respons form http://url/logout */
	Route::get('logout', function() {
	    Auth::logout();
	    return Redirect::to('/');
	});
/* Getting respons form http://url/register */
	Route::get('register', function()
	{
		return View::make('register');
	});
	Route::get('contacts','TourController@contacts'); 
	Route::get('tour/pdf', 'TourController@pdf');
    Route::post('/recoverpwd', function()
	{
		$email = Input::get('email');
		$checkemail = DB::table('users')->where('email','=', $email)->first();
		if($checkemail != ''){
			$token = "123";
		$mail =	Mail::send('emails.auth.reminder', array('token'=>$token ,'email'=>Input::get('email')), function($message)
				{
					$message->to(Input::get('email'))->subject('Password Reset Confirmation');
				});
if(!$mail) {
 	return View::make('index')->with('err','empty');
} else {
	$addtoken = DB::table('reset')->insert(array('hash'=>$token, 'expiry'=> date("d"),'requser_id'=>$checkemail->id ));
	return View::make('login')->with('success','Password Reset link has been sent to your Email');
}
		}else{
			return View::make('index')->with('err','empty');
		}
	});
	Route::get('reset', function()
	{
		$token = Input::get('token');
		$check = DB::table('reset')->where('hash','=',$token)->first();
/*		print_r($check);
		echo date("d");*/
		if($check->expiry == date("d") ){
		/*	echo  "if sta";*/
			return View::make('reset')->with('expire','no');
		}else{
			return View::make('reset')->with('expire','yes');
		}
	});
	Route::post('reset', function()
	{
		$pass = Input::get('newpwd');
		$cnfrmpass = Input::get('checkpwd');
		$token = Input::get('token');
		if($pass==$cnfrmpass){
			$useridd = DB::table('reset')->where('hash','=',$token)->first(array('requser_id'));
			$changepwd = DB::table('users')->where('id','=',$useridd->requser_id)->update(array('password' => Hash::make($cnfrmpass))); 
			$deltraces = DB::table('reset')->where('hash','=',$token)->delete();
			return View::make('login');
		}else{
			echo "fail ".$token;
		}
	});
	
	
	Route::post('login', function() {
    $userdata = array(
        'username'      => Input::get('username'),
        'password'      => Input::get('password')
    );
    if (Auth::attempt($userdata))
    { $username = Input::get('username');		  
	  $status = DB::table('users')->where('username','=',$username)->lists('status');
		if($status[0]=="1"){
			return Redirect::to('admin');			
		}else{		
        // we are now logged in, go to Account dashboard
        return Redirect::to('account');
	}
    }    
    else
    {
        // auth failure! lets go back to the login
        return Redirect::to('login')->with('login_errors', 'true');
    }
});

Route::post('register',  array('before' => 'csrf', function() {
    $userdata = array(
    	'first_name'	=> Input::get('first_name'),
    	'last_name'		=> Input::get('last_name'),
    	'email'			=> Input::get('email'),
        'username'      => Input::get('username'),
		'password'      => Hash::make(Input::get('password')),		
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
		'captcha'       => 'required|captcha',		
	);	
	$input = Input::all();	
			$v = Validator::make($input, $rules);
			if( $v->fails() ){
			    return Redirect::to('register')->withInput(Input::except('password'))->withErrors($v);
			}
			else{
			    Session::put('data', $userdata);
			    Session::put('pass',Input::get('password'));
			    return Redirect::to('plan');
			}
}));

Route::get('plan',function(){
	$data = DB::table('plan')->get();
	return View::make('plan')->with('data',$data);	
		});
Route::post('response','PaymentController@checkout');
 
Route::get('receipt',function(){
 return View::make('receipt');	
});
Route::get('onepagecheckout','PaymentController@onepagecehckout');
Route::get('plan/{action?}','PaymentController@selectplan');
Route::get('admin/plan/delete/{action?}','UserController@deleteoneplan');
Route::get('admin/deletepage/plan','UserController@deleteplan');
Route::post('admin/plan/update/{action?}','UserController@getplanupdate');
Route::get('admin/plan/edit/{action?}','UserController@getplanedit');
Route::post('admin/plan/create','UserController@postplancreate');
Route::get('admin/plan/add','UserController@getplanadd');
Route::get('admin/editpage/plan','UserController@getplanlist');
Route::post('admin/mail/many','MailController@postmailmany');
Route::post('admin/mail/one','MailController@postmailone');
Route::get('admin/mail/many','MailController@getmailmany');
Route::get('admin/mail/one','MailController@getmailone');
Route::get('admin/order/remove/{action?}','PaymentController@postorderremove');
Route::get('admin/order/update/{action?}','OrderController@getorderpage');
Route::post('admin/order/update/{action?}','OrderController@posteditform');
Route::get('admin/orders/edit/{action?}','OrderController@geteditform');
Route::get('admin/orders/review','OrderController@getdetail');
Route::get('admin/payment/update/{action?}','PaymentController@getpayment');
Route::post('admin/payment/update/{action?}','PaymentController@postpaymentedit');
Route::get('admin/payment/remove/{action?}','PaymentController@postpaymentremove');
Route::get('admin/payment/edit/{action?}','PaymentController@getpaymentedit');
Route::post('admin/payment/new','PaymentController@postpaymentadd');
Route::get('admin/payment/new','PaymentController@getpayment');
Route::get('admin/payment/add','PaymentController@getpaymentadd');
Route::get('admin/user/new','UserController@getuserall');
Route::post('admin/user/new','UserController@postusernew');
Route::get('admin/user/add','UserController@getuseradd');
Route::get('admin/user/delete/{action?}','UserController@getdelete');
Route::get('admin/user/update/{action?}','UserController@getuserall');
Route::post('admin/user/update/{action?}','UserController@getuserupdate');
Route::get('admin/user/edit/{action?}','UserController@getuseredit');
Route::post('admin/update/policy/{action?}','CmsController@getpolicyupdate');
Route::post('admin/update/faq/{action?}','CmsController@getfaqupdate');
Route::post('admin/update/terms/{action?}','CmsController@gettermupdate');
Route::get('admin/faq/edit/{action?}','CmsController@getfaqedit');
Route::get('admin/terms/edit/{action?}','CmsController@gettermedit');
Route::get('admin/policy/edit/{action?}','CmsController@getpolicyedit');
Route::post('admin/update/{action?}','CmsController@postupdatepage');
Route::post('admin/seo/update/{action?}','CmsController@postseopage');
Route::get('admin/seo/faq/{action?}','CmsController@editseofaq');
Route::get('admin/seo/edit/{action?}','CmsController@editseo');
Route::post('success','PaymentController@success');
Route::get('success','PaymentController@success');
Route::get('cancel','PaymentController@cancel');
Route::get('admin/edit/add/{action?}','CmsController@getaddform');	
Route::get('tour/{action?}','TourController@createpage');		
Route::post('admin/image/upload','CmsController@uploadimage');	
Route::post('admin/tour/delete/{action?}','CmsController@deleteoverview');
Route::post('admin/manage/{action?}','CmsController@manage');
Route::post('admin/check/{action?}','CmsController@check');
Route::post('admin/getform/{action?}','CmsController@image');  
Route::post('admin/pages/create','CmsController@postpage'); 
Route::post('admin/pages/update/{action?}','CmsController@postupdate');
Route::post('admin/update/page/faq','CmsController@faqupdate');
Route::post('admin/update/page/policy', 'CmsController@policyupdate');
Route::post('admin/update/page/terms', 'CmsController@termupdate');
Route::get('admin/pages/manage', 'CmsController@managepage');
Route::get('admin/pages/image', 'CmsController@updateimage');
Route::get('admin/edit/{action?}','CmsController@editpage');
Route::get('admin/delete/{action1?}/{action?}','CmsController@deletepage');
Route::get('admin/edit/{action1?}/{action?}','CmsController@geteditpage');
Route::get('admin/deletepage/faq','CmsController@deletefaq');
Route::get('admin/deletepage/{action?}','CmsController@deletetour');
Route::get('admin/editpage/faq','CmsController@editfaq');
Route::get('admin/editpage/policy','CmsController@editpolicy');
Route::get('admin/editpage/term','CmsController@editterms');
Route::get('admin/deletepage/policy','CmsController@deletepolicy');
Route::get('admin/deletepage/terms','CmsController@deleteterms');
Route::get('admin/faq/delete/{action?}','CmsController@deletefaqonce');
Route::get('admin/policy/delete/{action?}','CmsController@deletepolicyonce');
Route::get('admin/terms/delete/{action?}','CmsController@deletetermonce');
Route::get('admin/deleteimage/{action1?}/{action?}','CmsController@deleteimageonce');
Route::get('admin/pages/create','CmsController@createpage'); 	
Route::get('admin/pages/update','CmsController@updatepage');
Route::post('select/{action?}','PaymentController@get_login');
Route::post('checkout/{action?}','PaymentController@checkout');
Route::get('/admin','AdminController@index');
Route::get('admin/users','AdminController@users');
Route::get('admin/payment','AdminController@orders');
Route::get('admin/pages','AdminController@pages');
Route::get('admin/pages/tour','AdminController@tourpages');
Route::post('admin/pages/tour/title','AdminController@tour_title');
Route::post('admin/pages/tour','AdminController@tour_overview');
Route::get('admin/pages/faq','AdminController@faqpages');
Route::post('admin/pages/faq','AdminController@post_faqpages');
Route::get('admin/tour/overview','AdminController@tour_overview');
Route::get('admin/tour/minute','AdminController@tour_minut');
Route::post('admin/tour/pdf','AdminController@tour_pdf');
Route::post('admin/tour/contact','AdminController@tour_cont');
Route::post('admin/tour/contact/title','AdminController@contact_title');
Route::post('/admin/tour/pdf/title','AdminController@pdf_title');
Route::post('admin/tour/minute','AdminController@tour_minute');
Route::post('/admin/tour/minute/title','AdminController@minute_title');
Route::get('admin/tour/pdf','AdminController@tour_pd');
Route::get('admin/tour/contact','AdminController@tour_contact');
Route::get('admin/pages/privacy','AdminController@privacypages');
Route::get('account','AccountController@index');
Route::get('account/contacts','AccountController@contacts');
Route::get('account/tasks','AccountController@tasks');	
Route::post('account/tasks','AccountController@post_tasks');	
Route::get('account/preferences','AccountController@preferences');
Route::get('account/setting','UserController@get_setting');	
Route::get('account/edit/{action?}','UserController@getform');
Route::post('account/edit/{action?}','UserController@postform');		
Route::post('account/preferences','AccountController@post_preferences');
Route::get('account/create','AccountController@get_create');
Route::post('account/create','AccountController@post_create');
Route::post('account/autosave','AccountController@post_autosave');
Route::post('account/minute','AccountController@post_minute');
Route::get('account/minute','AccountController@get_minute');
Route::get('account/edit','AccountController@get_edit');	
Route::post('account/delminute','AccountController@post_delminute');
Route::get('account/reattend','AccountController@get_reattend');	
Route::get('account/notes','AccountController@get_notes');
Route::post('account/ajax','AccountController@post_ajax');
Route::post('account/minus','AccountController@post_minus');
Route::post('account/plus','AccountController@post_plus');
Route::post('account/delcontact','AccountController@post_delcontact');
Route::get('create_result', function()
	{	
		$id= Input::get('id');
		$view=Input::get('view'); 
		$sent =Input::get('sendnote');
		if($sent == "sent"){
		$sent_minute = DB::table('minutes')->where('mID', '=', $id)->update(array('mStatus' => 'sent'));
		
		}
		$minute = DB::table('minutes')->where('mID','=',$id)->join('users','id','=','user_id_minutes')->first(array('mID','mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));
		$attendees = DB::table('contacts')->join('attendee_Minutes', 'contacts.contactsID', '=', 'attendee_Minutes.a_id')->where('m_id', '=', $id)->get(array('cName','cEmail','condition'));
		$notes_meeting = DB::table('notes')->where('TYPE', '=' ,-1)->where('minute_id', '=' ,$id)->get();
		$action_meeting = DB::table('notes')->where('TYPE', '>' ,-1)->where('minute_id', '=' ,$id)->get();
	date_default_timezone_set('UTC');
	class PDF_result extends Fpdf {
		public $creator;
		public $time;
		public $logo;
		function __construct ($cr='',$tim='',$img='', $orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
			Fpdf::FPDF($orientation, $unit, $format);
			Fpdf::SetTopMargin($margin);
		    Fpdf::SetLeftMargin($margin);
			Fpdf::SetRightMargin($margin);
			Fpdf::SetAutoPageBreak(true, $margin);
			$this->creator =$cr;
			$this->time =$tim;
			$this->logo=$img;
		}
		function Header () {
			Fpdf::Image($logo,40,15,250);
			Fpdf::SetFont('Arial', 'U', 18);
			Fpdf::Cell(0, 40, "Meeting Minutes",'','','R');
			Fpdf::Ln(60);
			Fpdf::SetFont('Arial', '', 10);
			Fpdf::Cell(0,15, "Created By  : ".$creator,'','','R');
			Fpdf::Ln(20);
			Fpdf::SetFont('Arial', '', 10);
			Fpdf::Cell(0, 15, "Meeting Date/Time : ".$logo,'','','R');
			Fpdf::Ln(80);
		}
	}
	$bgcolor  = $minute->bgcolor;
	$pieces = explode(",", $bgcolor);
	$fontclr = $minute->fontcolor;
	$fontpieces = explode(",", $fontclr);
	$creator = $minute->username;
	$time = $minute->selected_date;
	$title = $minute->mTitle;
	$title = strip_tags($title);
	$agenda = $minute->mAgenda;
	$agenda = strip_tags($agenda);
	$attendee = $creator;
	$sattendee = array();
	foreach ($attendees as $contact) {
		if($contact->cName!=''){
			$attendee = $attendee.', '.$contact->cName;
			if($contact->condition == "absent"){
				$attendee = $attendee."(absent) ";
			}
		}
		array_push($sattendee, $contact->cEmail);
	}
	$pdf = new PDF_result($creator,$time,$minute->logo);
	Fpdf::AddPage();
	Fpdf::Image($minute->logo,40,15,250);
			Fpdf::SetFont('Arial', 'U', 18);
			Fpdf::Cell(0, 40, "Meeting Minutes",'','','R');
			Fpdf::Ln(60);
			Fpdf::SetFont('Arial', '', 10);
			Fpdf::Cell(0,15, "Created By  : ".$creator,'','','R');
			Fpdf::Ln(20);
			Fpdf::SetFont('Arial', '', 10);
			Fpdf::Cell(0, 15, "Meeting Date/Time : ".$time,'','','R');
	Fpdf::SetFont('Arial', 'B', 12);
	if($title != ''){
		Fpdf::Cell(100, 13, $title);
	}else{
		Fpdf::Cell(100, 13, "The meeting title is missing");
	}
	Fpdf::Ln(50);
	Fpdf::SetFillColor($pieces[0],$pieces[1],$pieces[2]);
	Fpdf::SetLineWidth(1);
	Fpdf::SetFont('Arial', '', 12);
	Fpdf::SetTextColor($fontpieces[0],$fontpieces[1],$fontpieces[2]);
	Fpdf::Cell(0, 25, "Meeting Agenda", 'LTR', 0, 'L', true);
	Fpdf::Ln(25);
	Fpdf::SetFillColor(255);
	Fpdf::SetFont('Arial', '', 10);
	Fpdf::SetTextColor(0);
	if($agenda != ''){
		$cleanAgenda = str_replace("&nbsp;", " ", $agenda);
		Fpdf::MultiCell(0, 30, $cleanAgenda , 'LRB', 'L');
	}else{
		Fpdf::MultiCell(0, 15, "The agenda for this meeting is missing", 'LRB', 'L');
	}
	Fpdf::Ln(50);
	Fpdf::SetFillColor($pieces[0],$pieces[1],$pieces[2]);
	Fpdf::SetLineWidth(1);
	Fpdf::SetFont('Arial', '', 12);
	Fpdf::SetTextColor($fontpieces[0],$fontpieces[1],$fontpieces[2]);
	Fpdf::Cell(0, 25, "Meeting Attendees", 'LTR', 0, 'L', true);
	Fpdf::Ln(25);
	Fpdf::SetFillColor(255);
	Fpdf::SetFont('Arial', '', 10);
	Fpdf::SetTextColor(0);
	Fpdf::MultiCell(0, 15, $attendee, 'LRB', 'L');
	Fpdf::Ln(50);

	if(!isset($_GET['agenda'])){
		Fpdf::SetFillColor($pieces[0],$pieces[1],$pieces[2]);
		Fpdf::SetLineWidth(1);
		Fpdf::SetFont('Arial', '', 12);
		Fpdf::SetTextColor($fontpieces[0],$fontpieces[1],$fontpieces[2]);
		Fpdf::Cell(0, 25, "Meeting Notes", 'LTR', 0, 'L', true);
		Fpdf::Ln(25);
		Fpdf::SetFillColor(255);
		Fpdf::SetFont('Arial', '', 10);
		Fpdf::SetTextColor(0);
		if(empty($notes_meeting)){Fpdf::MultiCell(0, 25, "No notes have been recorded for this meeting." , 'LRB', 'L');}
		foreach ($notes_meeting as $notes) {
			$cleanNotes = strip_tags($notes->description);
			$cleanNotes = str_replace("&nbsp;", " ", $cleanNotes);
			Fpdf::MultiCell(0, 25, $cleanNotes , 'LRB', 'L');		
		}
		Fpdf::Ln(50);
		Fpdf::SetFillColor($pieces[0],$pieces[1],$pieces[2]);
		Fpdf::SetLineWidth(1);
		Fpdf::SetFont('Arial', '', 12);
		Fpdf::SetTextColor($fontpieces[0],$fontpieces[1],$fontpieces[2]);
		Fpdf::Cell(0, 25, "Action Items", 'LTR', 0, 'L', true);
		Fpdf::Ln(25);
		Fpdf::SetFillColor(255);
		Fpdf::SetFont('Arial', '', 10);
		Fpdf::SetTextColor(0);
		if(empty($action_meeting)){Fpdf::MultiCell(0, 25, "No actions have been recorded for this meeting." , 'LRB', 'L');}
		foreach ($action_meeting as $action) {
			if($action->type=='0'){
				Fpdf::SetFont('Arial', '', 10);
				Fpdf::SetTextColor(0);
				$cleanAction = strip_tags($action->description);
				$cleanAction = str_replace("&nbsp;", " ", $cleanAction);
				Fpdf::MultiCell(0, 25, $cleanAction , 'LTR', 'L');	
			}else{
				Fpdf::SetFont('Arial', '', 10);
				Fpdf::SetTextColor(0);
				$cleanAction2 = strip_tags($action->description);
				$cleanAction2 = str_replace("&nbsp;", " ", $cleanAction2);
				Fpdf::MultiCell(0, 25, $cleanAction2 , 'LTR', 'L');
				$contacts_name = DB::table('contacts')->where('contactsID', '=' , $action->type)->first(array('cName')); 
				Fpdf::SetFont('Arial', 'I', 8);
				Fpdf::SetTextColor(153);
				Fpdf::MultiCell(0, 25, "Assigned To: ".$contacts_name->cName , 'LRB', 'L');	
			}
		}
	}
Fpdf::Output('../public/pdf/minitmeet'.$minute->mID.'.pdf', 'F');
if($view!="view"){
 $id= Input::get('id');
 $minute = DB::table('minutes')->where('mID','=',$id)->join('users','id','=','user_id_minutes')->first(array('mID','mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));
if(!isset($_GET['agenda'])){
	$subject = 'Your Meeting Notes';
	$type= "minutes";
}else{
	$subject= 'Your Meeting Agenda';
	$type = "agenda";
} 
$mail= Mail::send('emails.pdf', array('minute'=>$minute,'type'=>$type),function($message)
{   $id= Input::get('id'); 
	$minute = DB::table('minutes')->where('mID','=',$id)->join('users','id','=','user_id_minutes')->first(array('mID','mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));
    $attendees = DB::table('contacts')->join('attendee_Minutes', 'contacts.contactsID', '=', 'attendee_Minutes.a_id')->where('m_id', '=', $id)->lists('cEmail');

	if(!isset($_GET['agenda'])){
	$subject = 'Your Meeting Notes';
	$type= "minutes";
}else{
	$subject= 'Your Meeting Agenda';
	$type = "agenda";
}   $message->subject($subject);
    $message->to($attendees)->cc($minute->email);
    $message->attach('../public/pdf/minitmeet'.$minute->mID.'.pdf');
});	
$sent_minute=DB::table('minutes')->where('mID',$id)->update(array('mStatus'=>'sent'));
if(!$mail) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	
	 
        $sent_minute=DB::table('minutes')->where('mID',$id)->update(array('mStatus'=>'sent'));
	    return Redirect::to('account'); 
}
}
return Redirect::to(URL::to('/').'/pdf/minitmeet'.$minute->mID.'.pdf');
});
Route::resource('tour', 'TourController');
Route::get('{action?}','TourController@getcustom');
