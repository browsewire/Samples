<?php
// application/controllers/account.php
class AccountController extends BaseController
{public $restful = true;
    public function index()
    {
        $draft_minutes = DB::table('minutes')->where('user_id_minutes','=',Auth::user()->id)->where('mStatus','=','draft')->orderBy('mID', 'desc')->get();
        foreach ($draft_minutes as $draft){
            if($draft->mTitle== ''){
                $check_notes = DB::table('notes')->where('minute_id','=',$draft->mID)->first();
                if(!$check_notes){
                    $check_attende = DB::table('attendee_Minutes')->where('m_id','=',$draft->mID)->first();
                    if(!$check_attende){
                        $delete_draft = DB::table('minutes')->where('mID','=',$draft->mID)->delete();
                    }
                }
            }
        }
        $sent_minutes = DB::table('minutes')->where('user_id_minutes','=',Auth::user()->id)->where('mStatus','=','sent')->orderBy('mID', 'desc')->get(array('mID','mTitle','selected_date'));
        //print_r($sent_minutes); die();
       
       $recieved_minutes_id = DB::table('contacts')->join('attendee_Minutes', 'contactsID', '=', 'attendee_Minutes.a_id')->where('cEmail' , '=',Auth::user()->email)->get(array('m_id'));
       
        
        $recived_array = array(-1);
            foreach ($recieved_minutes_id as $key => $value) {
              array_push($recived_array, $value->m_id);
            }
        $recieved_minutes = DB::table('minutes')->whereIn('mID', $recived_array)->where('mStatus','=','sent')->orderBy('mID', 'desc')->get(array('mID','mTitle','selected_date'));
      
        return View::make('account.index')->with('draft_minutes', $draft_minutes)->with('recieved_minutes',$recieved_minutes)->with('sent_minutes',$sent_minutes);
    }
    public function post_delminute()
    {   
        $order = Input::get('order');
        $orderBy = Input::get('orderBy');
        if($order !='mTitle' && $order !='mDate'){
            $order = 'mID';
            $orderBy = 'desc';
        }
        $id = Input::get('note_id');
        $del = Input::get('del');
        if($del == "true"){
            $delete_minute =  DB::table('minutes')->where('mID', '=', $id )->delete();
            $delete_attendee_Minutes= DB::table('attendee_Minutes')->where('m_id', '=', $id )->delete();
            $delete_notes = DB::table('notes')->where('minute_id', '=', $id )->delete();
        }
        $draft_minutes = DB::table('minutes')->where('user_id_minutes','=',Auth::user()->id)->where('mStatus','=','draft')->orderBy($order, $orderBy)->get(array('mID','mTitle','mDate','selected_date'));
        return View::make('account.reminute')->with('draft_minutes', $draft_minutes);
    }
    public function post_delSentminute()
    {   

        $order = Input::get('order');
        $orderBy = Input::get('orderBy');
        if($order !='mTitle' && $order !='mDate'){
            $order = 'mID';
            $orderBy = 'desc';
        }
        $id = Input::get('note_id');
        $del = Input::get('del');
        if($del == "true"){
            $delete_minute =  DB::table('minutes')->where('mID', '=', $id )->delete();
            $delete_attendee_Minutes= DB::table('attendee_Minutes')->where('m_id', '=', $id )->delete();
            $delete_notes = DB::table('notes')->where('minute_id', '=', $id )->delete();
        }
        $sent_minutes = DB::table('minutes')->where('user_id_minutes','=',Auth::user()->id)->where('mStatus','=','sent')->orderBy($order,$orderBy)->get(array('mID','mTitle','mDate','selected_date'));
        return View::make('account.resentminute')->with('sent_minutes', $sent_minutes);
    }
    public function contacts()
    {   $order = "ASC";
        $contacts = DB::table('users_contacts')->join('contacts', 'users_contacts.c_id', '=', 'contacts.contactsID')->where('users_contacts.u_id','=',Auth::user()->id)->orderBy('cName')->get(array('cName','created_at','contactsID'));
        return View::make('account.contacts')->with('contacts', $contacts)->with('nextorder',$order);;
    }
    public function post_contacts()
    {   
        $curOrder = Input::get('order');
        if($curOrder =="ASC"){
            $order = "DESC";
        }else{
            $order = "ASC";
        }
        $contacts = DB::table('users_contacts')->join('contacts', 'users_contacts.c_id', '=', 'contacts.contactsID')->where('users_contacts.u_id','=',Auth::user()->id)->orderBy('cName',"$order")->get(array('cName','created_at','contactsID'));
        return View::make('account.contacts')->with('contacts', $contacts)->with('nextorder',$order);
    }
    public function preferences()
    {   $user = DB::table('users')->where('id','=',Auth::user()->id)->first();
        return View::make('account.preferences')->with('user',$user);
    }
    public function post_preferences()
    {   //print_r(Input::file('photo'));
        $mode = Input::get('mode');
        if($mode == "bg"){
            //echo "Set bg";
            $bgcolor = Input::get('bgcolor');
            //echo $bgcolor;
            $update_bg =DB::table('users')->where('id', '=', Auth::user()->id)->update(array('bgcolor' => $bgcolor)); 
        }elseif($mode=="fn") {
            //echo "Set fn";
            $fncolor = Input::get('fncolor');
            //echo $fncolor;
            $update_fn =DB::table('users')->where('id', '=', Auth::user()->id)->update(array('fontcolor' => $fncolor)); 
        }elseif($mode=='pwd'){
            $pwd = Hash::make(Input::get('password'));
            $update_pwd =DB::table('users')->where('id', '=', Auth::user()->id)->update(array('password' => $pwd)); 

        }else{
            $file = Input::all('photo');
/*            var_dump($file);*/
            $name =Input::file('photo');
/*            echo '<br>'.$name;*/
           $renamed= $name->getClientOriginalName();
/*            echo '<br>'.$renamed.'<br>';*/
            $uploading = Input::file('photo')->move('logos' ,$renamed );
/*            var_dump($uploading);
            echo '<br>';*/
            $update_img =DB::table('users')->where('id', '=', Auth::user()->id)->update(array('logo' => URL::to('/').'/logos/'.$renamed)); 
        return Redirect::to('account/preferences');
        }
    }
    public function tasks()
    {
        $tasks_pending = DB::table('notes')->join('contacts','contacts.contactsID','=','notes.type')->join('minutes','minutes.mID','=','minute_id')->where('notes.user_id', '=' , Auth::user()->id)->WhereNotIn('notes.type',array(-1,0))->where('cEmail','!=',Auth::user()->email)->where('state','=','pending')->where('mStatus','=','sent')->orderBy('cName')->get();
        $tasks_completed = DB::table('notes')->join('contacts','contacts.contactsID','=','notes.type')->join('minutes','minutes.mID','=','minute_id')->where('notes.user_id', '=' , Auth::user()->id)->WhereNotIn('notes.type',array(-1,0))->where('cEmail','!=',Auth::user()->email)->where('state','=','completed')->where('mStatus','=','sent')->orderBy('cName')->get(); 
        //$my_tasks = DB::table('contacts')->where('cEmail','=', Auth::user()->email)->join('notes','type','=','contacts.contactsID')->join('minutes','mID','=','notes.minute_id')->where('state','pending')->where('mStatus','=','sent')->join('users','id','=','notes.user_id')->get(); 
        $my_tasks = DB::table('contacts')->where('cEmail','=', Auth::user()->email)->join('notes','contacts.contactsID','=','notes.type')->where('state','=','pending')->join('minutes','minutes.mID','=','notes.minute_id')->where('mstatus','=','sent')->get(); 
    //print_r($my_tasks); die();
    // $my_tasks= array();
       return View::make('account.tasks')->with('tasks_pending',$tasks_pending)->with('tasks_completed',$tasks_completed)->with('my_tasks',$my_tasks);
    }
    public function get_edit()
    {
        $minute_id = Input::get('id');
        //session_start();
        $_SESSION['draft'] = $minute_id;
        //echo "id = ".$_SESSION['draft'];
        $found_minute = DB::table('minutes')->where('mID', '=' ,$_SESSION['draft'])->first();
        return View::make('account.edit')->with('minute',$found_minute);

    }
    public function get_profile()
    {
        return View::make('account.profile');
    }
    public function get_create()
    {
        $draft_id = DB::table('minutes')->insertGetId(array('mTitle' => '', 'mAgenda' => '', 'mDate' => date('Y-m-d H:i:s') , 'mStatus' => 'draft', 'user_id_minutes' =>Auth::user()->id, 'selected_date' => ''));
        //session_start();
        $_SESSION['draft'] = $draft_id;
        $contacts = DB::table('users_contacts')->join('contacts', 'users_contacts.c_id', '=', 'contacts.contactsID')->where('users_contacts.u_id','=',Auth::user()->id)->orderBy('cName')->get();
        return View::make('account.create')->with('contacts', $contacts);
    }
    public function post_create()
    {
		
        $mode = Input::get('mode');
        $id = Input::get('id');
        if($mode == 'condition'){
            $session_draft = Input::get('sessionid');
            $condition = Input::get('condition');
            if($condition == "present"){
                $make_absent = DB::table('attendee_Minutes')->where('a_id','=',$id)->where('m_id','=',$session_draft)->update(array('condition'=>'absent'));
               echo "absent";
            }else{
                $make_present = DB::table('attendee_Minutes')->where('a_id','=',$id)->where('m_id','=',$session_draft)->update(array('condition'=>'present'));
               echo "present";
            }
        }elseif ($mode == 'toaction') {
            $type = Input::get('type');
            if($type == ""){$type = 0;}
            $to_action = DB::table('notes')->where('notes_id','=',$id)->update(array('type'=>$type));
        }elseif ($mode == 'tonotes') {
            $to_notes = DB::table('notes')->where('notes_id','=',$id)->update(array('type'=>-1));
        }elseif ($mode == 'editnote') {
            $desc = Input::get('desc');
            $update_note = DB::table('notes')->where('notes_id','=',$id)->update(array('description' => $desc));
        }elseif ($mode == 'delnote') {
            $del_note = DB::table('notes')->where('notes_id','=',$id)->delete();
        }elseif ($mode =='togglecomment') {
            $current_state=Input::get('current_state');
            if($current_state == "Enable"){
                $enable_comment = DB::table('minutes')->where('mID','=',$id)->update(array('comment_state'=>'Enable'));
                echo "Disable";
            }else{
                $disable_comment = DB::table('minutes')->where('mID','=',$id)->update(array('comment_state'=>'Disable'));
                echo "Enable";
            }
        }
    }
    public function get_reattend()
    {   //session_start();
        $attendee = DB::table('contacts')->join('attendee_Minutes', 'contacts.contactsID', '=', 'attendee_Minutes.a_id')->where('m_id', '=', $_SESSION['draft'])->orderBy('cName')->get(array('cName','cEmail','contactsID','condition'));
        //print_r($attendee); 
        $atendes = array(-1);
        //print_r($atendes);
        foreach ($attendee as $key => $value) {
           array_push($atendes, $value->contactsID);
        }
        $contacts = DB::table('users_contacts')->join('contacts', 'users_contacts.c_id', '=', 'contacts.contactsID')->WhereNotIn('contactsID', $atendes)->where('users_contacts.u_id','=',Auth::user()->id)->orderBy('cName')->get();
        //print_r($contacts); 
        return View::make('account.reattend')->with('contacts', $contacts)->with('attendees',$attendee);
    }
    public function post_minus()
    {   //session_start();
        $id = Input::get('id');
        $affected = DB::table('attendee_Minutes')->where('m_id', '=' , $_SESSION['draft'])->where('a_id', '=', $id)->delete();
        //return true;
    }
    public function post_plus()
    {  // session_start();
        $id = Input::get('id');
        $draft_id = DB::table('attendee_Minutes')->insertGetId(array('a_id' => $id, 'm_id' => $_SESSION['draft'],'condition'=>'present'));
        //return $draft_id;
    }
    public function post_ajax()
    {   //session_start();
        $m_id = $_SESSION['draft'];
        $cName = Input::get('name');
        $cEmail = Input::get('email');
/**
Add condition if contact is already exists
*********************/
        $if_contact_exist = DB::table('contacts')->where('cEmail', '=', $cEmail)->first(array('contactsID'));
      // print_r($if_contact_exist);
        if(!$if_contact_exist){
            //echo "New contact creating,linking and marking as attendee<br>";
            $adding_contact = DB::table('contacts')->insertGetId(array('cName' => $cName,'cEmail' => $cEmail,'created_at'=>date('Y-m-d H:i:s')));

            $linking_contact_user = DB::table('users_contacts')->insertGetId(array('u_id' => Auth::user()->id,'c_id' => $adding_contact));
            $attendee = DB::table('attendee_Minutes')->insert(array('m_id' => $m_id,'a_id' => $adding_contact,'condition'=>'present'));
        }else{
            //echo "Arlreday in Contact checking if linked with this user<br>";
            $adding_contact = $if_contact_exist->contactsID;
            $if_linked = DB::table('users_contacts')->where('u_id','=', Auth::user()->id)->where('c_id','=', $adding_contact)->first();
            
            if(!$if_linked){
                //echo "not linked linking now and marking as attendee<br>";
                $linking_contact_user = DB::table('users_contacts')->insertGetId(array('u_id' => Auth::user()->id,'c_id' => $adding_contact));
                $attendee = DB::table('attendee_Minutes')->insert(array('m_id' => $m_id,'a_id' => $adding_contact,'condition'=>'present'));
            }else{
                //echo "Contact Is already added in your list<br>";
            }
        }
        
     return 1;
        
    }
    public function post_delcontact(){
        $id = Input::get('id');
        $name = Input::get('name');
        $order = Input::get('order');
        $del = Input::get('del');
        //echo $del;
        if($del == 'true'){
            //echo "I amin DEl";
            $deleteContact = DB::table('contacts')->where('contactsID', '=', $id)->delete();
            $deleteMinute = DB::table('attendee_Minutes')->where('a_id', '=', $id)->delete();
        }else{
            //echo "Update query"; 
            $update = DB::table('contacts')->where('contactsID', '=', $id)->update(array('cName' => $name)); 
        }
        $contacts = DB::table('users_contacts')->join('contacts', 'users_contacts.c_id', '=', 'contacts.contactsID')->where('users_contacts.u_id','=',Auth::user()->id)->orderBy('cName',"$order")->get(array('cName','created_at','contactsID'));
        return View::make('account.recontact')->with('contacts', $contacts)->with('nextorder',$order);
        
    }

    public function post_autosave()
    {
        //$new_minute = Input::get('check');
        //echo 'new_minute = '.$new_minute;
        //if($new_minute == 'true'){
            //echo "i am in new minute";
            //$draft_id = DB::table('minutes')->insertGetId(array('mTitle' => '', 'mAgenda' => '', 'mDate' => date('Y-m-d H:i:s') , 'mStatus' => 'draft'));
            $title = Input::get('title');
            $agenda = Input::get('agenda');
            $time = Input::get('time');

            //session_start();
            //$draft_id = $_SESSION['draft'];
            $draft_id = Input::get('id');
            echo $draft_id.'=updated';
            $affected = DB::table('minutes')->where('mID', '=', $draft_id)->update(array('mTitle' => $title, 'mAgenda' => $agenda, 'mDate' => date('Y-m-d H:i:s') , 'mStatus' => 'draft', 'user_id_minutes' =>Auth::user()->id, 'selected_date' => $time));
            echo '<br>updated';
        //}
        // echo "wihtout if statement";
    }
    public function get_minute()
    {   //session_start();
        $attendees = DB::table('contacts')->join('attendee_Minutes', 'contacts.contactsID', '=', 'attendee_Minutes.a_id')->where('m_id', '=', $_SESSION['draft'])->get(array('cName','cEmail','contactsID'));
        return View::make('account.minute')->with('attendees', $attendees);
    }
    public function post_minute()
    {   $desc = Input::get('desc');
        $type = Input::get('type');
        //session_start();
        $notes =DB::table('notes')->insertGetId(array('description' => $desc,'minute_id' =>$_SESSION['draft'], 'user_id' =>Auth::user()->id, 'type' =>$type,'state' =>'pending'));
        return $notes;
    }
    public function get_notes()
    {   //session_start();
        $notes_meeting = DB::table('notes')->where('minute_id', '=' ,$_SESSION['draft'])->where('user_id', '=' , Auth::user()->id)->get();
        return View::make('account.renotes')->with('notes_meeting', $notes_meeting);
    }
    public function post_tasks()
    {
        $mode = Input::get('mode');
        if($mode == 'markcomplete'){
            $noteid = Input::get('id');
            $note_complete = DB::table('notes')->where('notes_id','=',$noteid)->update(array('state' => 'completed'));
            /*Generating email*/
            $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->first();
            $minute = DB::table('minutes')->where('mID','=',$minute_id->minute_id)->join('users','id','=','user_id_minutes')->first(array('mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));

            $sattendee=$minute_id->cEmail;
            $attendee = $minute_id->cEmail;
            $body="markcomplete";
            $taskdetail = $minute_id->description;
            //$this->sendmail($attendee,$body,$minute,$taskdetail,$sattendee);
            $mail= Mail::send('emails.markcomplete', array('minute'=>$minute,'taskdetail'=>$taskdetail),function($message)
					{						   
						$noteid = Input::get('id');    
 					    $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->lists('cEmail');
    					$message->subject("Task Update Notification");
						$message->to($minute_id);						
					});
						
          if(!$mail) {
          return "Mailer Error: " . $mail->ErrorInfo;
        } else {
          return "Message sent!";
        }
            
        }elseif ($mode =="reopentask") {
            $noteid = Input::get('id');
            $note_pending = DB::table('notes')->where('notes_id','=',$noteid)->update(array('state' => 'pending'));
            /*Generating email*/
            $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->first();
            $minute = DB::table('minutes')->where('mID','=',$minute_id->minute_id)->join('users','id','=','user_id_minutes')->first(array('mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));
            $sattendee=$minute_id->cEmail;
            $attendee = $minute_id->cEmail;
            $body="reopen";
            $taskdetail = $minute_id->description;
            //$this->sendmail($attendee,$body,$minute,$taskdetail,$sattendee);
            $mail= Mail::send('emails.reopen', array('minute'=>$minute,'taskdetail'=>$taskdetail),function($message)
					{     $noteid = Input::get('id');    
						  $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->lists('cEmail');

						  $message->subject("Task Update Notification");
						  $message->to($minute_id);
					
					});	
		if(!$mail) {
          return "Mailer Error: " . $mail->ErrorInfo;
        } else {
          return "Message sent!";
        }		
        }elseif ($mode =="reminder") {
            $noteid = Input::get('id');
            $split =  explode("#", $noteid);
            $noteid = $split[0];
            $reminder = $split[1];
            $note_pending = DB::table('notes')->where('notes_id','=',$noteid)->update(array('reminder' => $reminder+1));
            /*Generating email*/
            $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->first();
            $minute = DB::table('minutes')->where('mID','=',$minute_id->minute_id)->join('users','id','=','user_id_minutes')->first(array('mTitle','mAgenda','username','email','first_name','last_name','selected_date','bgcolor','fontcolor' ,'logo'));
            $sattendee=$minute_id->cEmail;
            $attendee = $minute_id->cEmail;
            $body="reminder";
            $taskdetail = $minute_id->description;
            //$this->sendmail($attendee,$body,$minute,$taskdetail,$sattendee,$reminder+1);
            $mail= Mail::send('emails.reminder', array('minute'=>$minute,'taskdetail'=>$taskdetail,'reminder'=>$reminder),function($message)
					{     $noteid = Input::get('id');    
						  $minute_id = DB::table('notes')->where('notes_id','=',$noteid)->join('contacts','contactsID','=','type')->lists('cEmail');
						  $message->subject("Task Reminder");
						  $message->to($minute_id);					
					});
	if(!$mail){
          return "Mailer Error: " . $mail->ErrorInfo;
        } else {
          return "Message sent!";
        }		
						
        }elseif ($mode =="refresh") {
            $noteid = Input::get('id');
        $tasks_pending = DB::table('notes')->join('contacts','contacts.contactsID','=','notes.type')->join('minutes','minutes.mID','=','minute_id')->where('notes.user_id', '=' , Auth::user()->id)->WhereNotIn('notes.type',array(-1,0))->where('cemail','!=',Auth::user()->email)->where('state','=','pending')->where('mstatus','=','sent')->orderBy('cName')->get();
        $tasks_completed = DB::table('notes')->join('contacts','contacts.contactsID','=','notes.type')->join('minutes','minutes.mID','=','minute_id')->where('notes.user_id', '=' , Auth::user()->id)->WhereNotIn('notes.type',array(-1,0))->where('cemail','!=',Auth::user()->email)->where('state','=','completed')->where('mstatus','=','sent')->orderBy('cName')->get(); 
        $my_tasks = DB::table('contacts')->where('cemail','=', Auth::user()->email)->join('notes','contacts.contactsID','=','notes.type')->where('state','=','pending')->join('minutes','minutes.mID','=','minute_id')->where('mstatus','=','sent')->join('users','id','=','user_id')->get();//join('minutes','minutes.mID','=','minute_id')->where('notes.user_id', '=' , Auth::user()->id)->WhereNotIn('notes.type',array(-1,0))->where('cemail','=',Auth::user()->email)->where('state','=','pending')->where('mstatus','=','sent')->orderBy('cName')->get(); 
        return View::make('account.retask')->with('tasks_pending',$tasks_pending)->with('tasks_completed',$tasks_completed)->with('my_tasks',$my_tasks)->with('tab',$noteid);
        }
    }

}
