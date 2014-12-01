<?php

class TempRegApiController extends BaseController{

 //check driver nin
  public function CheckDriverNin(){
      $input = Input::json();
	  
	  //print_r($input);
       $driver_nin = $input->get('drivernin');
	  
	  //CHECK IF DRIVER NIN ALREADY EXIST
	   $driver_status = Driver::where('drivers_nin', $driver_nin)->count();	
	   if($driver_status){
	   //send driver id if found
	   $driver = Driver::where('drivers_nin', $driver_nin)->first(); 
	                $driver_id = $driver->id;
					$driver_name = $driver->drivers_fname. ' '.$driver->drivers_lname;
	    
		$info = array('driver_id'=>$driver_id,'name'=>$driver_name);
	    Helpers::response_data('200','Already Exist',$info);	   
	   }else{
	    Helpers::response_data('400','No found',"not found" );
	   }  

  }  
  
  //save driver and return his id  
  public function adddriver(){
      $input = Input::json();
      $authorized_license_no = $input->get('dlic');
	  $authorized_status = Driver::where('drivers_license_no', $authorized_license_no)->count();         
              //print_r($input);
              if($authorized_status == NULL){
                    $country_id = DB::table('countries')->where('country_name',$input->get('country'))->first()->id;
				      
				    $status_id = DB::table('driving_status')->where('driving_status_name',$input->get('status'))->first()->id;
					$authorized_info['drivers_fname']          = $input->get('fname');
					$authorized_info['drivers_mname']          = $input->get('mname');
					$authorized_info['drivers_lname']          = $input->get('lname');
					$authorized_info['drivers_nin']            = $input->get('nin');
					$authorized_info['drivers_license_no']     = $input->get('dlic');
					$authorized_info['drivers_street']         = $input->get('street');
					$authorized_info['drivers_city']           = $input->get('city');
					$authorized_info['drivers_po_box']         = $input->get('po');
					$authorized_info['drivers_country']        = $country_id;
					$authorized_info['drivers_cell1']          = $input->get('cell1');
					$authorized_info['drivers_cell2']          = $input->get('cell2');
					$authorized_info['drivers_email']          = $input->get('email');
					$authorized_info['drivers_driving_status'] = $status_id;

					$insert_authorized_into_driver_table = Driver::create($authorized_info);
					$authorized_ids = $insert_authorized_into_driver_table->id;
					$driver_name = $insert_authorized_into_driver_table->drivers_fname.' '.$insert_authorized_into_driver_table->drivers_lname;
				}
				// IF DRIVER EXISTS, GET HIS ID
				else {
				    $driver = Driver::where('drivers_license_no', $authorized_license_no)->first();
					$authorized_ids = $driver->id;
					$driver_name = $driver->drivers_fname. ' '.$driver->drivers_lname; 
					
				} 
			 $info = array('driver_id'=>$authorized_ids,'name'=>$driver_name);	
			 //send driver id in response
			 Helpers::response_data('200','success',$info);
  
  }
  
  //issue fine controller
  
  public function issueFine(){
  
    $input  =  Input::json();
  
  //latitude and longitude details
	$latitude   =  $input->get('latitude');
	$longitude  =  $input->get('longitude');
	
	$signature  =  $input->get('signature');
	if($signature){
	 $signature_path =  $this->saveimage($signature);
	}

	//fined by user 
	$officer_data = $input->get('finedby');
	$finedata     =  $input->get('fine');
	$fines_name   =  $finedata['fines'];
	$info         =  $finedata['info'];
	$vehicle_vin  =  $info['vehiclevin'];
	$driver_id    =  $info['driver']['driver_id'];
	//GROUP ALL FINES NAME ACCORDING TO USER TYPE
	
	foreach($fines_name as $names){	
	 $data[$names['type']][]= $names['name']['id'];	
	 $fine_names[$names['type']][]= $names['name']['name'];	
	}
	$today = date('mdY');
	//save vehicle and get its ID
	$sequence = VehicleTemp::orderBy('id','DESC')->first();
	$sequence_id = $sequence->id + 1001;
	$temp_no = "TEMP-".$today."-".$sequence_id;
	$vehicletemp['vehicles_vin'] = $vehicle_vin;
	$vehicletemp['temp_registration_num'] = $temp_no;
	$vehicle = VehicleTemp::create($vehicletemp);
	
    $vehicle_id = $vehicle->id; 
   //fine to vehicle
    $registartion_num = $vehicle->temp_registration_num;
		
   
   if(array_key_exists('vehicle', $data)){
   
	    $vehiclefine_ids = $data['vehicle'];
		$vehiclefine = $fine_names['vehicle'];
		
	    //check if we have vehicle violations names	 
	     $fine_id = $vehiclefine_ids;
		 
		 $fines_all = VehicleFine::whereIn('id',$fine_id)->get();
		 
		 $fine = VehicleFine::find($fine_id[0]);
		 $sequence = ViolateVehicleTemp::orderBy('id','DESC')->first();
	     $sequence_id = $sequence->id + 1001;
		
		//citation number	
		
		 $citaion_number = "TEMP-".$fine->vehicle_violation_code.'-'.$today.'-'.$officer_data['badge_id_number'].'-'.$sequence_id;		 
        	
			//SAVE FINES FOR DRIVERS
		 foreach($fine_id as $id){
		 //echo $id;
		 $fineinfo['driver_id']        =    $driver_id;
		 $fineinfo['temp_vehicle_id']       =    $vehicle_id;
		 $fineinfo['vehicle_fine_id']  =    $id;
		 $fineinfo['vehicle_fine_unique_id'] = $citaion_number;
		 $fineinfo['officer_id']      =  $officer_data['badge_id_number'];
		 $fineinfo['longitude']       =   $longitude;
		 $fineinfo['latitude']        =  $latitude;
		 $fineinfo['status']          =	  '2';
		 
		 $saved_fine = ViolateVehicleTemp::create($fineinfo);
		 }
		 
		  if($signature){
	          //type 1 for vehicle signature type fine
			 $data_signature['fine_id']   =  $saved_fine->id;
			 $data_signature['type']      = 'temp_1';
			 $data_signature['signature'] =  $signature; 
			 $data_signature['path']      =  $signature_path;
			 
 	 
	 DB::table('signature')->insert($data_signature); 
	 
	 } 
		
		 //SEND EMAIL HERE
		$title = "New traffic citation: non-registered vehicle";
		
	    $temp_registartion_id = $vehicle->temp_registration_num;
		
		$amount =  array_sum(VehicleFine::whereIn('id',$fine_id)->lists('vehicle_fine_ammount'));
		
		$drivers_email = Driver::where('id',$driver_id)->lists('drivers_email');
		$driver = Driver::where('id',$driver_id)->first()->toArray();	
		
		$sender = array_unique($drivers_email);
         
        $data_array  = array('registration_number'=>$temp_registartion_id,'fine_descp'=>$vehiclefine,'citation_num'=>$citaion_number,'amount'=>$amount,'driver'=>$driver)	;
       	if(array_key_exists('vehicle',$data) AND array_key_exists('driver',$data)){
		//check if both fines are issued
		  $email_data_both['sender']      = $sender;
		  $email_data_both['data_vehicle'] =  $data_array;
		  $email_data_both['sms_vehicle'] =   "New traffic fine Citation#:".$citaion_number.	 " Driver: ".$driver['drivers_fname'] . " " .$driver['drivers_lname']." Reg#:".$temp_registartion_id. " Amount:".$amount." Pay fines at GRA location.";	
		 
	  
	   }else{ 
		
		$sent = Mail::send('emails.temp', $data_array,function($message) use ($title,$sender,$signature_path)
				{  
					$message->to($sender)->subject($title);
					$message->attach($signature_path);
				});
				 $template = "New traffic fine Citation#:".$citaion_number.	 " Driver: ".$driver['drivers_fname'] . " " .$driver['drivers_lname']." Reg#:".$temp_registartion_id. " Amount:".$amount." Pay fines at GRA location.";		
	
	            $to = $driver['drivers_isd1'].$driver['drivers_cell1'];    
	            Helpers::SendSms($to,$template);
			
		 }
		 
		  $vehicle_fine_amount = $amount;
		
	   $printer_data_vehicle['citation_number']      = $citaion_number;	  
	   $printer_data_vehicle['fines']                = $fines_all;
	   $printer_data_vehicle['offender']             = $driver;
		 
		 
		}
		
	 
		
		 //fine to driver
 if(array_key_exists('driver', $data)){
	
	 $driverfines_id = $data['driver'];
   
	 $fine_id = $driverfines_id;
	 $fines_all =   DriverFine::whereIn('id',$fine_id)->get();  
	 $fine = DriverFine::find($fine_id[0]);
	 $sequence = ViolateDriverTemp::orderBy('id','DESC')->first();
	 $sequence_id = $sequence->id + 1001;
    //citation number	
	 $citaion_number = "TEMP-".$fine->driver_violation_code.'-'.$today.'-'.$officer_data['badge_id_number'].'-'.$sequence_id;
	
	 //SAVE FINES FOR DRIVERS
	 foreach($fine_id as $id){	 
	 $fineinfo['driver_id']         =    $driver_id;
	 $fineinfo['temp_vehicle_id']   =   $vehicle_id;
	 $fineinfo['driver_fine_id']    =    $id;
	 $fineinfo['driver_fine_unique_id'] = $citaion_number;
	 $fineinfo['officer_id']      =   $officer_data['badge_id_number'];
	 $fineinfo['longitude']       =   $longitude;
     $fineinfo['latitude']        =   $latitude;
     $fineinfo['status']          =	  '2';	 
	 
	 $saved_fine =  ViolateDriverTemp::create($fineinfo);	  
	  
	  }
	  
	  
	  if($signature){
	          //type 0 for driver signature type fine
			 $data_signature['fine_id']   =  $saved_fine->id;
			 $data_signature['type']      = 'temp_0';
			 $data_signature['signature'] =  $signature; 
			 $data_signature['path']      =  $signature_path;
			 
 	 
	 DB::table('signature')->insert($data_signature); 
	 
	 } 
	 //email here
	$title = "New traffic citation: non-registered vehicle";
	
	$registration_number = $vehicle->temp_registration_num;
	
	$driverfines = $fine_names['driver'];	
	
    $amount =  array_sum(DriverFine::whereIn('id',$fine_id)->lists('driver_fine_ammount'));
	
	$drivers_email = Driver::where('id',$driver_id)->lists('drivers_email');
	
	$driver = Driver::where('id',$driver_id)->first();	
		
	$sender = array_unique($drivers_email);
	
	$data_email_array = array('registration_number'=>$registration_number,'fine_descp'=>$driverfines,'citation_num'=>$citaion_number,'amount'=>$amount,'driver'=>$driver);

		if(array_key_exists('vehicle',$data) AND array_key_exists('driver',$data)){
		 //check if both  fine type issued
		 $email_data_both['driver_data'] = $data_email_array;
		 $email_data_both['sms_driver']  =  "New traffic fine Citation#:".$citaion_number.	 " Driver: ".$driver->drivers_fname . " " .$driver->drivers_lname." Reg#:".$registration_number. " Amount:".$amount." Pay fines at GRA location.";
		}
		else
		{
	
	     $sent = Mail::send('emails.temp', $data_email_array, function($message) use ($title,$sender,$signature_path)
			{  
				$message->to($sender)->subject($title);
				$message->attach($signature_path);
			});
			
	$template = "New traffic fine Citation#:".$citaion_number.	 " Driver: ".$driver->drivers_fname . " " .$driver->drivers_lname." Reg#:".$registration_number. " Amount:".$amount." Pay fines at GRA location.";
    
	$to = $driver->drivers_isd1.$driver->drivers_cell1;    
	Helpers::SendSms($to,$template);		
			
	 }
	   $driver_fine_amount = $amount;
		
	   $printer_data_driver['citation_number']      = $citaion_number;	  
	   $printer_data_driver['fines']                = $fines_all;
	   $printer_data_driver['offender']             = $driver;
	 
	 }else{
	 
	   $printer_data_driver = null;
	 }
	 
	 if(isset($email_data_both)){
	      //print_r($email_data_both);
		 Helpers::smsemailTemp($driver->drivers_cell1,$email_data_both,$signature_path);
	   }
	   
	 //error handling for fines
	   if(!isset($driver_fine_amount)){
	      $driver_fine_amount = 0;
	   }
	   if(!isset($vehicle_fine_amount)){
	      $vehicle_fine_amount = 0;
	   }  
	   
	   $total_amount = $vehicle_fine_amount + $driver_fine_amount;
	   
	   $success = array('driver'=>$printer_data_driver,'vehicle'=>$printer_data_vehicle,'reg'=>$registartion_num,'amount'=>$total_amount);
	 
	 
   Helpers::response_data('200','Success',$success);
  
  }
  
  //save image for testing 
  
  public function saveimage($data){   
   
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	$name  =Helpers::randomString(10) .".png"; 
    $path  = public_path()."/upload/".$name;
	file_put_contents($path, $data);
    return $path;  
  }
 

}

?>