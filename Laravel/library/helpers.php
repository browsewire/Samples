<?php
class Helpers{

  //function to send custom response on API call
  public static function response_data($response_code,$response_status,$response_data){  
    //header("HTTP/1.0 ,$response_code $response_status ");
    $response_all = array(
	              'code'  =>$response_code,
				  'status'=>$response_status,
                  'data'  =>$response_data ,
  				  ) ;
    
   echo json_encode($response_all);
   
  }
  
   //make serach data for vehicle search response
  public static function search_data($vehicle_data,$driver=NULL){
   
   if(!empty($vehicle_data)){
	
	 $vehicles_vin = $vehicle_data->vehicles_vin;
     $vehicles_model_id = $vehicle_data->vehicles_model_id;
  	 $vehicles_use_type_id = $vehicle_data->vehicles_use_type;
	 $vehicle_color = Color::find($vehicle_data->vehicles_color)->colors_name;
	
	 $owner = $vehicle_data->owners;
	 
	
	 foreach($owner as $own){
	  $owner_names['name'][] = $own->drivers_fname . " " .$own->drivers_lname;
	 
	 }
	 if(!isset($owner_names)){
	   $owner_names = null;
	   
	 }
	 
	 
    
	 $model = Model::find($vehicles_model_id);
  	 $model_make_id = $model->model_make_id;
	 $model_name = $model->model_name;
	 
	 $vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;
	  
	
	 $result_data[] = array(
	                      'id'=>$vehicle_data->id,
						  'vin_number' => $vehicles_vin,
						  'model_make_id'=>$model_make_id,
						  'model_name'=>$model_name,
						  'color'=>$vehicle_color,
						  'owner'=>$owner_names,
						  'vehicle_use_types_name'=>$vehicle_use_types_name,
	                         );
							 
	 if($driver){
      return $result_data;	 
     }	 
							 
    Helpers::response_data('200','success',$result_data);
	}else
	   {
	       Helpers::response_data('404','No record found',NULL);
	   }
  }
  
  //driver response
 public static function DriverResponse($driver){
   
	 $driver_id  = $driver->id;
	 $count =  VehicleDriverOwner::where('vehicle_driver_owners_driver_id',$driver_id)->count();
	 if($count){
     $driver_vehicle_owner_id = VehicleDriverOwner::where('vehicle_driver_owners_driver_id',$driver_id)->first()->vehicle_driver_owners_vehicle_id;
     
	if(isset($driver_vehicle_owner_id)){
    $vehicle_data  = Vehicle::where('id',$driver_vehicle_owner_id)->first();
			if(empty($vehicle_data)){
				$owner_data = array();
			}else{
				$owner_data =  Helpers::search_data($vehicle_data,$driver_id);
			}

    }
	 else{
	   $owner_data = array();
	  }
	 }else{
	  $owner_data = array();
	 }
	
     //check if user is authorised 
    $driver_vehicle_auth_count= VehicleDriverAuthorized::where('vehicle_driver_authorized_driver_id',$driver_id)->count();
	if($driver_vehicle_auth_count){
	 //if found return data
	$driver_vehicle_auth_id= VehicleDriverAuthorized::where('vehicle_driver_authorized_driver_id',$driver_id)->first()->vehicle_driver_authorized_vehicle_id;
	if(!empty($driver_vehicle_auth_id)){
	$vehicle_data  = Vehicle::where('id',$driver_vehicle_auth_id)->first();
	if(empty($vehicle_data)){
       $auth_data = array();
      }
	  else
	   {
 	    $auth_data = Helpers::search_data($vehicle_data,$driver_id);
       }	
	}
	 else
	    {
	    $auth_data = array();
	    }
	}else
	    {
		 $auth_data = array();
		}
	
	
    $data = array('owners'=>$owner_data,'auth'=>$auth_data);
	
    echo Helpers::response_data('200','Success',$data);

 }
  
  //response for owner nin
  public static function owner_nin_response($owner){
     if($owner){
			    $owner_id = $owner->id;
                $vehicle_id = VehicleDriverOwner::where('vehicle_driver_owners_driver_id',$owner_id)->lists('vehicle_driver_owners_vehicle_id');
			  
			  
			  $vehicles = Vehicle::whereIn('id',$vehicle_id)->get()->toArray();
			  //print_r($vehicle);
			  $searched_data_all = array();
			  foreach( $vehicles as $vehicle){
			             $vehicles_vin = $vehicle['vehicles_vin'];
						 $vehicles_model_id = $vehicle['vehicles_model_id'];
						 $vehicles_use_type_id = $vehicle['vehicles_use_type'];
						 
						 $model = Model::find($vehicles_model_id);
						 $model_make_id = $model->model_make_id;
						 $model_name = $model->model_name;

						 $vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;
						 
						 $result_data[]= array(
											  'id'=>$vehicle['id'],
											  'vin_number' => $vehicles_vin,
											  'model_make_id'=>$model_make_id,
											  'model_name'=>$model_name,
											  'vehicle_use_types_name'=> $vehicle_use_types_name,
												 );
			  }
			   Helpers::response_data('200','success',$result_data);
  }

}
 //sending emails 
  public static function SendMAil($owners_email,$driver_email,$status,$data,$name){
    
   $title= "Driver Status Change:".$status;
   
   $sent = Mail::send('emails.status', array('status'=>$status,'fines'=>$data,'name'=>$name), function($message) use ($title,$driver_email,$owners_email)
			{  
				$message->to($driver_email)->cc($owners_email)->subject($title);
			});
			
	   foreach($data as $fine){   
	   $fines[] =  $fine->name.":".$fine->created_at.":".$fine->fine_points .",";   
	   }
	   //print_r($fines);
	    $driver = $name->toArray();
        $to = "drivrs_no"; 
        $template = "Driving status has been update to ".$status." for ".$driver['0']['drivers_fname']." ".$driver['0']['drivers_lname']."
        ". implode(" ",$fines)."    
		Please contact your nearest police station for any questions
		Pay fines at GRA location.";		  
        //Helpers::SendSms($to,$template);
  }
  //functionality for sending messages
  public static function SendSms($to,$template){
        $fileUrl =  public_path()."/packages/twilio/Services/Twilio.php";
		File::getRequire($fileUrl);
		
		//check if number contain + at start. if not concatenate
		$check_num = substr($to, 0, 1);
		if($check_num !== '+'){
		 $to = '+'.$to;
		}
		
		//set your AccountSid and AuthToken from www.twilio.com/user/account
		$AccountSid = "AC091be30fb3a12b4da6540a7ebacb420b";
		$AuthToken = "f430bbbc0a6433dfa00e18330cf6bda3";
		 
		$client = new Services_Twilio($AccountSid, $AuthToken);	
		try{
		
		$message = $client->account->messages->create(array(
			"From" => "+12407725261",
			"To" =>   $to,
			"Body" => $template,
		));	
        } catch(Services_Twilio_RestException $e){
         $e->getMessage();

       }
  }
  
  
  public static function smsemail($to,$data,$signature_path){
      
     $sms_template = $data['sms_vehicle'] . $data['sms_driver'] ;	  
	 Helpers::SendSms($to,$sms_template);
	 
	 $title  = "New Citation Issued";
     $sender = $data['sender'];	  
	 $data_mail  = array('vehicle'=>$data['vehicle_data'],'driver'=>$data['data_driver']);
	 
	 Mail::send('emails.citationboth', $data_mail, function($message) use ($title,$sender,$signature_path)
			{  
				$message->to($sender)->subject($title);
				$message->attach($signature_path);
			});
   
  
  }
  
  
  //randomstring
  
  public static function randomString($length){
  
			return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

	  }	
	  
//email and sms for temp regisration
	
public static function smsemailTemp($to,$data,$signature_path){
      
     $sms_template = $data['sms_vehicle'] . $data['sms_driver'] ;	  
	 Helpers::SendSms($to,$sms_template);
	 
	 $title  = "New Citation Issued";
     $sender = $data['sender'];	  
	 $data_mail  = array('vehicle'=>$data['data_vehicle'],'driver'=>$data['driver_data']);
	 
	 Mail::send('emails.tempcitationboth', $data_mail, function($message) use ($title,$sender,$signature_path)
			{  
				$message->to($sender)->subject($title);
				$message->attach($signature_path);
			});
   
  
  }  



}


?>