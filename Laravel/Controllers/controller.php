<?php

class VehicleController extends \BaseController {

	private $model, $vehicleUseType, $color, $country, $drivingStatus, $vehiclestatus;

	public function __construct(Model $model, VehicleUseType $vehicleUseType, Color $color, Country $country, DrivingStatus $drivingStatus, VehicleStatus $vehiclestatus){
		$this->model = $model;
		$this->vehicleUseType = $vehicleUseType;
		$this->color = $color;
		$this->country = $country;
		$this->drivingStatus = $drivingStatus;
		$this->vehiclestatus = $vehiclestatus;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	


		Mail::send('testmail', [], function($message){
			$message->to('kanavk@ocodewire.com')->Subject('Testing Like A Pro');
		});
	}


	/**
	 * Show the form for creating a new vehicle.
	 *
	 * @return View(vehicle.create)
	 */
	public function create()
	{
		// BEGIN ALL DATA NEEDED BY REGISTRATION FORM
		$modelYears        = ['-1' => 'Select Vehicle Year'] + $this->model->getListDistinctModelYears();
		$modelMake         = ['-1' => 'Select Make'] + $this->model->distinct()->orderBy('model_make_id')->lists('model_make_id', 'model_make_id');
		$vehicleUseType    = ['-1' => 'Select Vehicle Use Type'] + $this->vehicleUseType->lists('vehicle_use_types_name', 'id');
		$colorList         = ['-1' => 'Select Color'] + $this->color->lists('colors_name', 'id');
		$vehicleStatus     = $this->vehiclestatus->lists('vehicle_status_name', 'id');
		$country           = ['-1' => 'Select Country'] + $this->country->lists('country_name', 'id');
		$drivingStatusName =  $this->drivingStatus->lists('driving_status_name', 'id');
		// END ALL DATA NEEDED BY REGISTRATION FORM

		//MAKING AN ARRAY OF DATA THAT IS NEEDED IN FORM
		$data = compact('modelYears', 'modelMake', 'vehicleUseType', 'vehicleStatus', 'colorList', 'drivingStatusName', 'country');

		return View::make('vehicle.create', $data);
	}


	/**
	 * Store a newly created vehicle in database.
	 *
	 * @return Response
	 */
	public function store()
	{

		//VEHICLE DATA
		$vehicles_year         = trim(Input::get('vehicles_year'));
		$vehicles_make_id      = trim(Input::get('vehicles_make_id'));
		$vehicles_name_trim    = trim(Input::get('vehicles_name_trim'));
		$vehicles_name_trim_ar = explode(',', $vehicles_name_trim);
		$model_name            = trim($vehicles_name_trim_ar[0]);
		if(count($vehicles_name_trim_ar) > 1)
			$model_trim        = trim($vehicles_name_trim_ar[1]);
		else
		     $model_trim       = "";
		$vehicles_body         = trim(Input::get('vehicles_body'));
		if($vehicles_body      == -1) $vehicles_body = "";
		$vehicles_weight_kg    = trim(Input::get('vehicles_weight_kg'));

		// BEGIN ADDING NEW WEIGHT TO MODEL
		if(Input::get('new_wt') == 1){
			// IF BODY IS NULL (SOME MODELS HAS NULL BODY)
			if($vehicles_body == ""){
				// GETTING MODEL
				$model = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->whereNull('model_body')->where('model_weight_kg', NULL)->first();
			}else {
				$model = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->where('model_weight_kg', NULL)->first();
			}

			$model->model_weight_kg = $vehicles_weight_kg;
			$model->save();
	
		}
		// END ADDING NEW WEIGHT TO MODEL
		
		// BEGIN ADDING NEW MODEL INTO DATABASE
		if(Input::get('new_model') == 1){

			// IF BOTH ARE NOT BLANK
			if($model_trim != "" && $vehicles_body != ""){
				$newModel = Model::create(['model_make_id' => $vehicles_make_id, 'model_name' => $model_name, 'model_trim' => $model_trim, 'model_year' => $vehicles_year, 'model_body' => $vehicles_body, 'model_weight_kg' => $vehicles_weight_kg]);
			}
			// TRIM IS BLANK BUT BODY IS NOT
			else if($model_trim == "" && $vehicles_body != ""){
				$newModel = Model::create(['model_make_id' => $vehicles_make_id, 'model_name' => $model_name, 'model_trim' => $model_trim, 'model_year' => $vehicles_year, 'model_body' => $vehicles_body, 'model_weight_kg' => $vehicles_weight_kg]);
			}
			// TRIM IS NOT BLANK BUT BODY IS
			else if($model_trim != "" && $vehicles_body == ""){
				$newModel = Model::create(['model_make_id' => $vehicles_make_id, 'model_name' => $model_name, 'model_trim' => $model_trim, 'model_year' => $vehicles_year, 'model_weight_kg' => $vehicles_weight_kg]);
			}
			// BOTH ARE BLANK
			else {
				$newModel = Model::create(['model_make_id' => $vehicles_make_id, 'model_name' => $model_name, 'model_trim' => $model_trim, 'model_year' => $vehicles_year, 'model_weight_kg' => $vehicles_weight_kg]);
			}

			$newModelId = $newModel->id;
		}
		// END ADDING NEW MODEL INTO DATABASE
		
		// BEGIN VEHICLE
		if($vehicles_body != ""){
			$vehicle = Input::only(['vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_body', 'vehicles_weight_kg', 'vehicles_use_type', 'vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer']);
		}else {
			$vehicle = Input::only(['vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_weight_kg', 'vehicles_use_type', 'vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer']);
		}
		
		$validator_vehicle = Validator::make($vehicle, Vehicle::$rules);

		if($validator_vehicle->passes()){
			// GETTING AND ADDING MODEL ID
			
			// IF NEW MODEL WAS CREATED
			if(isset($newModelId) && $newModelId !=""){
				$vehicle['vehicles_model_id'] = $newModelId;
			}
			// MODEL WAS FETCHED FROM DB
			else{
				// IF BODY IS NULL
				if($vehicles_body == ""){
					// GETTING MODEL
					$vehicle['vehicles_model_id'] = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->whereNull('model_body')->first()->id;
				}else {
					$vehicle['vehicles_model_id'] = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->first()->id;
				}
			}

			
			// INSERT VEHICLE DATA AND GET ID
			$vehicle_inserted_id = Vehicle::create($vehicle)->id;
		}
		// VALIDATION DOESN'T PASS
		else{
			return Redirect::route('vehicle.create')->withErrors($validator_vehicle)->withInput();
			
		}
		// END VEHICLE
		
		// BEGIN OWNERS
		$owners_index = Input::get('owners_index');
		$owners_index_arr = array_filter(explode(',', $owners_index));

		
		// LOOP THROUGH EACH OWNER AND ASSOCIATE WITH DRIVERS
		foreach($owners_index_arr as $owners_index_id){
			$drivers_license_no = Input::get('drivers_license_no'.$owners_index_id);
			if(trim($drivers_license_no) !=""){
				$drivers_status = Driver::where('drivers_license_no', $drivers_license_no)->first();
				
				// IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($drivers_status == NULL)
				{
					
					$owner_info['drivers_fname']          = Input::get('drivers_fname'.$owners_index_id);
					$owner_info['drivers_mname']          = Input::get('drivers_mname'.$owners_index_id);
					$owner_info['drivers_lname']          = Input::get('drivers_lname'.$owners_index_id);
					$owner_info['drivers_nin']            = Input::get('drivers_nin'.$owners_index_id);
					$owner_info['drivers_license_no']     = Input::get('drivers_license_no'.$owners_index_id);
					$owner_info['drivers_street']         = Input::get('drivers_street'.$owners_index_id);
					$owner_info['drivers_city']           = Input::get('drivers_city'.$owners_index_id);
					$owner_info['drivers_po_box']         = Input::get('drivers_po_box'.$owners_index_id);
					$owner_info['drivers_country']        = Input::get('drivers_country'.$owners_index_id);
					$owner_info['drivers_cell1']          = Input::get('drivers_cell1'.$owners_index_id);
					$owner_info['drivers_cell2']          = Input::get('drivers_cell2'.$owners_index_id);
					$owner_info['drivers_email']          = Input::get('drivers_email'.$owners_index_id);
					$owner_info['drivers_driving_status'] = Input::get('drivers_driving_status'.$owners_index_id);


					$insert_owner_into_driver_table = Driver::create($owner_info);
					// USED TO ASSOCIATE WITH VEHICLE
					$owner_ids[] = $insert_owner_into_driver_table->id;

					// USED TO SEND SMS
					$ownerNamePh[$owner_info['drivers_cell1']]['name'] = $owner_info['drivers_fname']." ".$owner_info['drivers_lname'];
					$ownerNamePh[$owner_info['drivers_cell1']]['address'] = $owner_info['drivers_street'].", ".$owner_info['drivers_city']." - ".$owner_info['drivers_po_box'];
					$ownerNamePh[$owner_info['drivers_cell1']]['email'] = $owner_info['drivers_email'];

					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else
				{
					$driverExist = Driver::where('drivers_license_no', $drivers_license_no)->first();
					// USED TO ASSOCIATE WITH VEHICLE
					$owner_ids[] = $driverExist->id;

					// USED TO SEND SMS
					$ownerNamePh[$driverExist->drivers_cell1]['name'] = $driverExist->drivers_fname." ".$driverExist->drivers_lname;
					$ownerNamePh[$driverExist->drivers_cell1]['address'] = $driverExist->drivers_street." ".$driverExist->drivers_city." - ".$driverExist->drivers_po_box;
					$ownerNamePh[$driverExist->drivers_cell1]['email'] = $driverExist->drivers_email;

				}
			}
				
		}

		// LINK VEHICLE WITH OWNERS
		if(!empty($owner_ids)){
			foreach($owner_ids as $owner_ids_fet){
				$owner_ids_fet = (int) $owner_ids_fet;
				
				Vehicle::find($vehicle_inserted_id)->owners()->attach($owner_ids_fet);
			}
		}
		// END OWNERS

		//BEGIN AUTHORIZED DRIVERS
		$authorized_index = Input::get('authorized_index');

		// IF AUTHORIZED DRIVERS EXIST, ASSOCIATE WITH DRIVERS.(CHECKING USING LICENSE)
		if($authorized_index!=""){
			$authorized_index_arr = explode(',', $authorized_index);

			foreach($authorized_index_arr as $authorized_index_id){
				$authorized_license_no = Input::get('authorized_license_no'.$authorized_index_id);
				$authorized_status = Driver::where('drivers_license_no', $authorized_license_no)->first();
				

				//IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($authorized_status == NULL){

					$authorized_info['drivers_fname']          = Input::get('authorized_fname'.$authorized_index_id);
					$authorized_info['drivers_mname']          = Input::get('authorized_mname'.$authorized_index_id);
					$authorized_info['drivers_lname']          = Input::get('authorized_lname'.$authorized_index_id);
					$authorized_info['drivers_nin']            = Input::get('authorized_nin'.$authorized_index_id);
					$authorized_info['drivers_license_no']     = Input::get('authorized_license_no'.$authorized_index_id);
					$authorized_info['drivers_street']         = Input::get('authorized_street'.$authorized_index_id);
					$authorized_info['drivers_city']           = Input::get('authorized_city'.$authorized_index_id);
					$authorized_info['drivers_po_box']         = Input::get('authorized_po_box'.$authorized_index_id);
					$authorized_info['drivers_country']        = Input::get('authorized_country'.$authorized_index_id);
					$authorized_info['drivers_cell1']          = Input::get('authorized_cell1'.$authorized_index_id);
					$authorized_info['drivers_cell2']          = Input::get('authorized_cell2'.$authorized_index_id);
					$authorized_info['drivers_email']          = Input::get('authorized_email'.$authorized_index_id);
					$authorized_info['drivers_driving_status'] = Input::get('authorized_driving_status'.$authorized_index_id);

					$insert_authorized_into_driver_table = Driver::create($authorized_info);
					$authorized_ids[] = $insert_authorized_into_driver_table->id;
					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else {
					$authorized_ids[] = Driver::where('drivers_license_no', $authorized_license_no)->first()->id;
				}
			}

			// LINK VEHICLE WITH AUTHORIZED DRIVERS
			foreach($authorized_ids as $authorized_ids_fet){
				$authorized_ids_fet = (int) $authorized_ids_fet;
				
				Vehicle::find($vehicle_inserted_id)->authorizedDrivers()->attach($authorized_ids_fet);
			}
		}
		// END AUTHORIZED DRIVERS



		// BEGIN INSURANCE
		if(Input::get('insurances_company')!="")
		{
			$insurance_arr = new Insurance(Input::only('insurances_company', 'insurances_policy_no', 'insurances_exp_date', 'insurances_agent_fname', 'insurances_agent_lname', 'insurances_agent_cell', 'insurances_agent_city', 'insurances_agent_email'));
			
			Vehicle::find($vehicle_inserted_id)->insurance()->save($insurance_arr);
			
		}
		// END INSURANCE


		// BEGIN LIEN HOLDER
		if(Input::get('lien_index'))
		{
			$lien_arr = new Lien(Input::only('liens_collateral_id', 'liens_collateral_value', 'liens_bank_name', 'liens_bank_branch', 'liens_bank_street', 'liens_bank_city'));
			//$lien_arr['liens_vehicle_id'] = $vehicle_inserted_id;
			//Lien::create($lien_arr);
			Vehicle::find($vehicle_inserted_id)->lien()->save($lien_arr);
		}
		// END LIEN HOLDER
		

		// BEGIN FILES
		$files_col = Input::file();
		$files_count =  count(array_filter($files_col['files']));

		// IF FILES EXISTS
		if($files_count){
			foreach($files_col['files'] as $files){
				$filename_ar   = explode('.', $files->getClientOriginalName());
				$document_ext  = end($filename_ar);
				$path          = public_path().'/vehicledata/documents';
				
				// GENERATE RANDOM FILE NAME AND ADD EXTENSION
				$randName      = md5(rand() * time());
				$document_name = $randName . '.' . $document_ext;
				
				// MOVE FILE AND ENTRY INTO DATABASE
				if($files->move($path, $document_name)) {
					//Document::create(['documents_vehicle_id' => $vehicle_inserted_id, 'documents_name' => $document_name]);
					Vehicle::find($vehicle_inserted_id)->documents()->save(new Document(['documents_name' => $document_name]));
				}
			}
		}
		// END FILES
		
		
		// BEGIN REGISTRATION
		if(isset($vehicle_inserted_id) && $vehicle_inserted_id !=""){
			$registrations_vehicle_id       = $vehicle_inserted_id;
			$registrations_no               = Input::get('registrations_no');
			$registrations_licence_plate_no = Input::get('registrations_licence_plate_no');

			if($registrations_no !="" && $registrations_licence_plate_no != "" && $registrations_vehicle_id != ""){
				$vehicles_use_type = Input::get('vehicles_use_type');
				$vehicles_class    = Input::get('vehicles_class');

				if($vehicles_use_type !="" && $vehicles_class !=""){

					$vehicles_use_type_table_name = VehicleUseType::find($vehicles_use_type)->vehicle_use_types_table_name;

					//REGISTRATION FEES
					$vehicles_class_col_name = $vehicles_use_type_table_name.'_total';
					$registrations_fees = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;

					// INCREMENT REGISTRATION SEQUENCE
					$vehicles_sequence_col_name = $vehicles_use_type_table_name.'_sequence';
					$currentSequence = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_sequence_col_name;
					$newSequence = $currentSequence+1;

					DB::table($vehicles_use_type_table_name)->where('id', $vehicles_class)->update([$vehicles_sequence_col_name => $newSequence]);
					
					$registration_ar = compact('registrations_vehicle_id', 'registrations_no', 'registrations_licence_plate_no', 'registrations_fees');
					//Registration::create($registration_ar);
					Vehicle::find($vehicle_inserted_id)->registration()->save(new Registration($registration_ar));

					// BEGIN TAKE LOGS
					$newVehiclesStatus = Input::get('vehicles_status');
					$newVehicleColor = Input::get('vehicles_color');
					$newVehicleUseType = Input::get('vehicles_use_type');
					$newVehiclesRegistrationNo = Input::get('registrations_no');
					$vehicles_odometer = Input::get('vehicles_odometer');
					
					LogVehicleStatus::create(['log_vehicle_status_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_status_vehicle_status_id' => $newVehiclesStatus]);					
					
					LogVehicleColor::create(['log_vehicle_color_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_color_color_id' => $newVehicleColor]);
					
					LogVehicleUseType::create(['log_vehicle_use_type_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_use_type_use_type' => $newVehicleUseType, 'log_vehicle_use_type_registration_no' => $newVehiclesRegistrationNo]);
					
					LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_odometer_old_odometer' => $vehicles_odometer, 'log_vehicle_odometer_status' => 1]);
					// END TAKE LOGS

					// BEGIN ASSOCIATE TEMPORARY VEHICLE FINES(IF ANY)										
					$vehicles_vin = Input::get('vehicles_vin');
					$vehicleTemp = VehicleTemp::whereVehiclesVin($vehicles_vin)->first();
					if($vehicleTemp) {

						// VEHICLE FINES
						$violateVehicleTemp = $vehicleTemp->tempVehicleViolatile;

						if($violateVehicleTemp->count()){
							foreach($violateVehicleTemp as $violateVehicleTempFet){
								ViolateVehicle::create(['vehicle_id' => $registrations_vehicle_id, 'driver_id' => $violateVehicleTempFet->driver_id ,'vehicle_fine_id' => $violateVehicleTempFet->vehicle_fine_id,'vehicle_fine_unique_id' => $violateVehicleTempFet->vehicle_fine_unique_id,'officer_id' => $violateVehicleTempFet->officer_id,'geo_location' => $violateVehicleTempFet->geo_location,'location_name' => $violateVehicleTempFet->location_name,'longitude' => $violateVehicleTempFet->longitude,'latitude' => $violateVehicleTempFet->latitude,'status'=>2]);

								ViolateVehicleTemp::find($violateVehicleTempFet->id)->update(['status' => 1]);

							}
						}

						//DRIVER FINES
						$violateDriverTemp = $vehicleTemp->tempDriverViolatile;

						if($violateDriverTemp->count()){
							foreach($violateDriverTemp as $violateDriverTempFet){
								ViolateDriver::create(['vehicle_id' => $registrations_vehicle_id, 'driver_id' => $owner_ids[0] ,'driver_fine_id' => $violateDriverTempFet->driver_fine_id,'driver_fine_unique_id' => $violateDriverTempFet->driver_fine_unique_id,'officer_id' => $violateDriverTempFet->officer_id,'geo_location' => $violateDriverTempFet->geo_location,'location_name' => $violateDriverTempFet->location_name,'longitude' => $violateDriverTempFet->longitude,'latitude' => $violateDriverTempFet->latitude,'status'=>2]);

								ViolateDriverTemp::find($violateDriverTempFet->id)->update(['status' => 1]);
							}
						}
						
					}
					
					//BEGIN SEND EMAIL
					$owners = Driver::find($owner_ids);
					$namesAr = $owners->lists('drivers_lname', 'drivers_fname');
					foreach($namesAr as $fname => $lname){
						$names[] = $fname." ".$lname;
					}
					$names = implode(', ', $names);

					$emails = $owners->lists('drivers_email');
					$model = Model::find($vehicle['vehicles_model_id']);
					$color = Color::find($newVehicleColor)->colors_name;

					
					$data = compact('names', 'owners', 'model', 'color', 'newVehiclesRegistrationNo', 'registrations_licence_plate_no');
					Mail::send('emails.vehicle.registration', $data, function($message) use($emails)
					{
						$message->to($emails)->subject('New vehicle Registration');
					});
					//END SEND EMAIL
				
				
					// RETURN TO PRINT OUT
					return Redirect::route('vehicle.print', [$registrations_vehicle_id]);
				}
			}
		}else{
			echo "Nothing is saved because fields are not filled";
			die();
		} 
		// END REGISTRATION
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$vehicle = Vehicle::withTrashed()->find($id);
		if(Vehicle::vehicleStickerPrefix($id))
			$vehicle->sticker_prefix = Vehicle::vehicleStickerPrefix($id);
		$registration = $vehicle->registrationTrashed;				
		$vehicle['vehicles_class_name'] = Vehicle::vehicleClassName($id);
		$owners = $vehicle->owners;
		$authorizedDr = $vehicle->authorizedDrivers;
		$documents = $vehicle->documents;
		$insurance = $vehicle->insurance;
		$lien = $vehicle->lien;

		// BEGIN SETTING VEHICLE AND REGISTRATION STATUS 
		/*
		* Vehicle Status ($registration->veh_status)
		* Vehicle is new                       = 1
		* Vehicle is old and never transferred = 2 (Should Update Odometer)
		* Vehicle has been transferred         = 3
		* Vehicle is old and transferred       = 4 (Should Update Odometer)
		* 
		*/
	
		/*
		* Registration Status ($registration->reg_status)
		* Need To Register = 1
		* 
		*/
		
		$vehicleHistoryCount = count(Vehicle::getVehicleHistory($id));

		// IF ROAD TAX WAS ISSUED BEFORE (ALSO CHECKING IF ROAD TAX IS EXPIRED)
		if($registration->registrations_last_renewal){

			// VEHICLE IS OLD AND NEVER TRANSFERRED
			if($vehicleHistoryCount == 1)
				$registration->veh_status = 2;
			// VEHICLE IS OLD AND HAS BEEN TRASNFERRED
			else {
				$vehilceHistory = Vehicle::getVehicleHistory($id);
				$lastTransferredTo = end($vehilceHistory);
				if($lastTransferredTo != $id)
					$registration->veh_status = 3;
				else 
					$registration->veh_status = 4;
			}

			$renewal = $registration->registrations_last_renewal;
			$registration->sticker_reg_date = date("M dS, Y", strtotime($renewal));
			$registration->expiry = "Dec 31st, ".date("Y", strtotime($renewal));	

			// IS ROAD TAX EXPIRED
			$curYear = date("Y");
			$roadTaxYear =  date("Y", strtotime($renewal));

			// NEED TO REGISTER
			if($curYear > $roadTaxYear) $registration->reg_status = 1;
			$registration->reg_status = 1;
		}
		// NO ROAD TAX WAS ISSUED, CHECK IS IT A NEW VEHICLE OR TRANSFERRED VEHICLE
		else {
			// IF VEHICLE WAS NEVER TRANSFERED (NEW VEHICLE)		
			if($vehicleHistoryCount == 1){
				$registration->veh_status = 1;
			}
			// IF VEHICLE WAS TRANSFERRED
			else if($vehicleHistoryCount > 1){
				$vehilceHistory = Vehicle::getVehicleHistory($id);
				$lastTransferredTo = end($vehilceHistory);
				if($lastTransferredTo != $id)
					$registration->veh_status = 3;
			}
			// NEED TO REGISTER
			$registration->reg_status = 1;
		}
		

		// END SETTING VEHICLE AND REGISTRATION STATUS 
		//return $registration->veh_status;
		$data = compact('registration', 'vehicle', 'owners', 'authorizedDr', 'documents', 'insurance', 'lien');
		return View::make('vehicle.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// BEGIN ALL DATA NEEDED BY EDIT FORM
		
		//BEGIN VEHICLE DATA
		$vehicle = Vehicle::find($id);

		$vehicles_vin = $vehicle->vehicles_vin;
		$vehicles_year = $vehicle->model->model_year;
		$vehicles_make_id = $vehicle->model->model_make_id;
		$model_name = $vehicle->model->model_name;
		$model_trim = $vehicle->model->model_trim;
		$vehicles_name_trim = $model_name.", ".$model_trim;
		$vehicles_body = $vehicle->model->model_body;
		$vehicles_weight_kg = $vehicle->vehicles_weight_kg;
		$vehicles_status = $vehicle->vehicles_status;
		$vehicles_color = $vehicle->vehicles_color;
		$vehicles_odometer = $vehicle->vehicles_odometer;
		$vehicles_use_type = $vehicle->vehicles_use_type;

		$vehicles_class = $vehicle->vehicles_class;

		$vehicles_use_type_table_name = $vehicle->vehicleUseType->vehicle_use_types_table_name;

		// BEGIN VEHICLES GENERIC LIST
		$vehicles_class_col_name = $vehicles_use_type_table_name.'_class';
		$vehicles_class_name = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;

		$vehicles_class_ar = ['-1' => 'Select Class'] + DB::table($vehicles_use_type_table_name)->lists($vehicles_use_type_table_name.'_class', 'id');

		// IF VEHICLE USE TYPE IS COMMERCIAL PASSENGERS
		if($vehicles_use_type == 2) {
			$noOfPas = ['-1' => 'Select No. Of Passengers'] +  DB::table($vehicles_use_type_table_name)->lists('fees_commercial_passengers_no_of_passenger', 'id');
		}else $noOfPas = "";

		$model_make_ar = ['-1' => 'Select Make'] + Model::where('model_year', $vehicles_year)->distinct()->orderBy('model_make_id')->lists('model_make_id', 'model_make_id');
		$model_make_ar['add_new'] = "Add New";

		$vehicles_name_trim_arr = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->get(['model_name', 'model_trim'])->toArray();
		
		foreach($vehicles_name_trim_arr as $vehicles_name_trim_arr_fet){
				$name_trim = implode(', ', $vehicles_name_trim_arr_fet);
				$vehicles_name_trim_ar[$name_trim] = $name_trim;
		}

		$vehicles_name_trim_ar = array_unique($vehicles_name_trim_ar);
		asort($vehicles_name_trim_ar);
		$vehicles_name_trim_ar = ['-1' => 'Select Model'] + $vehicles_name_trim_ar;

		$vehicles_body_ar = ['-1' => 'Select Body Style'] + array_filter(array_unique(Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->lists('model_body', 'model_body')));

		
		$model_weight_kg_ar = ['-1' => "Select Gross Weight"] + array_filter(array_unique(Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_year', $vehicles_year)->where('model_body', $vehicles_body)->lists('model_weight_kg', 'model_weight_kg')));
		// END VEHICLES GENERIC LIST
		
		// END VEHICLE DATA

		// BEGIN OWNERS
		$owners = $vehicle->owners;
		
		$owners_index_range = range(1, $owners->count());
		//$old_owners_index = implode(',', $owners_index_range);
		$old_owners_index = implode(',',$owners->lists('id'));

		// END OWNERS

		//BEGIN AUTHORIZED
		$authorized = $vehicle->authorizedDrivers;
		if($authorized->count() > 0){
			$old_authorized_index = implode(',', $authorized->lists('id'));
		}else $old_authorized_index = "";		
		// END AUTHORIZED
		
		// REGISTRATION
		$registration = $vehicle->registration;
		// NEED TO SEND THIS SEPERATELY AS BECAUSE IS NEEDED IN JQUERY
		$registrations_no = $registration->registrations_no;

		// DOCUMENTS
		$documents = $vehicle->documents;
		if($documents->count() > 0){
			$documents_index_range = $documents->lists('id');
			$documents_index = implode(',', $documents_index_range);
		}else $documents_index = "";

		// INSURANCE
		$insurance = $vehicle->insurance;

		//LIEN
		$lien = $vehicle->lien;

		// GENERIC DATA
		$modelYears        = ['-1' => 'Select Vehicle Year'] + Model::distinct()->orderBy('model_year', 'desc')->lists('model_year', 'model_year');

		$vehicleStatus     = VehicleStatus::lists('vehicle_status_name', 'id');

		$colorList         = ['-1' => 'Select Color'] + Color::lists('colors_name', 'id');

		$vehicleUseType    = ['-1' => 'Select Vehicle Use Type'] + VehicleUseType::lists('vehicle_use_types_name', 'id');
		
		$country           = ['-1' => 'Select Country'] + Country::lists('country_name', 'id');
		$drivingStatusName =  DrivingStatus::lists('driving_status_name', 'id');

		// END ALL DATA NEEDED BY REGISTRATION FORM

		//MAKING AN ARRAY OF DATA THAT IS NEEDED IN FORM
		$data = compact('vehicle','vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_body', 'vehicles_weight_kg', 'vehicles_status', 'vehicles_color', 'vehicles_odometer', 'vehicles_use_type', 'vehicles_class','vehicles_class_name', 'vehicles_class_ar', 'noOfPas', 'model_make_ar', 'vehicles_name_trim_ar', 'vehicles_body_ar', 'model_weight_kg_ar', 'modelYears', 'modelMake', 'vehicleUseType', 'vehicleStatus', 'colorList', 'drivingStatusName', 'country', 'owners', 'old_owners_index', 'old_authorized_index', 'authorized', 'authorized_index', 'registration', 'registrations_no', 'insurance', 'lien', 'documents', 'documents_index');

		return View::make('vehicle.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$vehicle = Vehicle::find($id);

		// LOGS
		$oldVehiclesStatus = $vehicle->vehicles_status;
		$newVehiclesStatus = Input::get('vehicles_status');

		$oldvehicleColor = $vehicle->color->id;
		$newVehicleColor = Input::get('vehicles_color');

		$oldVehicleUseType = $vehicle->vehicles_use_type;
		$newVehicleUseType = Input::get('vehicles_use_type');
		$vehicles_class = Input::get('vehicles_class');

		$oldVehiclesRegistrationNo = $vehicle->registration->registrations_no;
		$newVehiclesRegistrationNo = Input::get('registrations_no');

		$oldOdometer = $vehicle->vehicles_odometer;
		$newOdometer = Input::get('vehicles_odometer');


		// IF VEHICLE STATUS IS CHANGED, ADD LOG
		if($oldVehiclesStatus != $newVehiclesStatus){
			LogVehicleStatus::create(['log_vehicle_status_vehicle_id' => $id, 'log_vehicle_status_vehicle_status_id' => $newVehiclesStatus]);
		}
		// IF VEHICLE COLOR IS CHANGED, ADD LOG
		if($oldvehicleColor != $newVehicleColor){
			LogVehicleColor::create(['log_vehicle_color_vehicle_id' => $id, 'log_vehicle_color_color_id' => $newVehicleColor]);
		}

		// IF VEHICLE USE TYPE IS CHANGED, TAKE LOG (ALSO TAKING LOG OF ODOMETER AND INCREMENT SEQUENCE)
		if($oldVehicleUseType != $newVehicleUseType){
			LogVehicleUseType::create(['log_vehicle_use_type_vehicle_id' => $id, 'log_vehicle_use_type_use_type' => $newVehicleUseType, 'log_vehicle_use_type_registration_no' => $newVehiclesRegistrationNo]);

			// INCREMENTING SEQUENCE
			$vehicles_use_type_table_name = VehicleUseType::find($newVehicleUseType)->vehicle_use_types_table_name;
			$vehicles_sequence_col_name = $vehicles_use_type_table_name.'_sequence';
			$currentSequence = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_sequence_col_name;
			$newSequence = $currentSequence+1;

			DB::table($vehicles_use_type_table_name)->where('id', $vehicles_class)->update([$vehicles_sequence_col_name => $newSequence]);
			

			// TAKING LOG OF ODOMETER
			$vehicles_odometer = Input::get('vehicles_odometer');
			LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $id, 'log_vehicle_odometer_old_odometer' => $vehicles_odometer, 'log_vehicle_odometer_status' => 2]);
		}
		// USE TYPE NOT CHANGED, BUT ODOMETER WAS CHANGED
		elseif($oldOdometer != $newOdometer) {
			LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $id, 'log_vehicle_odometer_old_odometer' => $newOdometer, 'log_vehicle_odometer_status' => 4]);

		}
		
		// BEGIN UPDATE VEHICLE DATA		
		$vehicle = Input::only(['vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer']);
		Vehicle::where('id', $id)->update($vehicle);
		// END UPDATE VEHICLE DATA	
		
		// BEGIN OWNERS
		
		//OLD OWNERS
		$old_owners = Vehicle::find($id)->owners->lists('id');
	
		//UPDATED OLD OWNERS		
		$updated_old_owners_index = Input::get('old_owners_index');
		$updated_owners_index_arr = array_filter(explode(',', $updated_old_owners_index));

		//DELETED OWNERS
		$deleted_owners = array_diff($old_owners, $updated_owners_index_arr);

		// DELETE EACH DELETED OWNER FROM DATABASE
		foreach($deleted_owners as $deleted_owner_id){
			VehicleDriverOwner::where('vehicle_driver_owners_vehicle_id', $id)->where('vehicle_driver_owners_driver_id', $deleted_owner_id)->delete();
		}

		//RETAINED OWNERS
		$retained_owners = array_intersect($old_owners, $updated_owners_index_arr);

		// UPDATE RETAINED OWNERS
		foreach($retained_owners as $retained_owner){

			$retained_owner_info['drivers_fname']          = Input::get('drivers_fname'.$retained_owner);
			$retained_owner_info['drivers_mname']          = Input::get('drivers_mname'.$retained_owner);
			$retained_owner_info['drivers_lname']          = Input::get('drivers_lname'.$retained_owner);
			$retained_owner_info['drivers_nin']            = Input::get('drivers_nin'.$retained_owner);
			$retained_owner_info['drivers_license_no']     = Input::get('drivers_license_no'.$retained_owner);
			$retained_owner_info['drivers_street']         = Input::get('drivers_street'.$retained_owner);
			$retained_owner_info['drivers_city']           = Input::get('drivers_city'.$retained_owner);
			$retained_owner_info['drivers_po_box']         = Input::get('drivers_po_box'.$retained_owner);
			$retained_owner_info['drivers_country']        = Input::get('drivers_country'.$retained_owner);
			$retained_owner_info['drivers_cell1']          = Input::get('drivers_cell1'.$retained_owner);
			$retained_owner_info['drivers_cell2']          = Input::get('drivers_cell2'.$retained_owner);
			$retained_owner_info['drivers_email']          = Input::get('drivers_email'.$retained_owner);
			$retained_owner_info['drivers_driving_status'] = Input::get('drivers_driving_status'.$retained_owner);

			Driver::find($retained_owner)->update($retained_owner_info);

		}

		// END OWNERS

		
		//BEGIN AUTHORIZED DRIVERS
		$old_authorized = Vehicle::find($id)->authorizedDrivers->lists('id');

		//UPDATED OLD AUTHORIZED DRIVERS
		$updated_old_authorized_index = Input::get('old_authorized_index');
		$updated_authorized_index_arr = array_filter(explode(',', $updated_old_authorized_index));

		//DELETED AUTHORIZED DRIVERS
		$deleted_authorized = array_diff($old_authorized, $updated_authorized_index_arr);

		//DELETE EACH DELETED AUTHORIZED DRIVER FROM DATABASE
		foreach($deleted_authorized as $deleted_authorized_id){
			VehicleDriverAuthorized::where('vehicle_driver_authorized_vehicle_id', $id)->where('vehicle_driver_authorized_driver_id', $deleted_authorized_id)->delete();
		}

		//RETAINED AUTHORIZED DRIVERS
		$retained_authorized = array_intersect($old_authorized, $updated_authorized_index_arr);

		// UPDATE RETAINED AUTHORIZED DRIVERS
		foreach($retained_authorized as $retained_authorize){

			$retained_authorized_info['drivers_fname']          = Input::get('authorized_fname'.$retained_authorize);
			$retained_authorized_info['drivers_mname']          = Input::get('authorized_mname'.$retained_authorize);
			$retained_authorized_info['drivers_lname']          = Input::get('authorized_lname'.$retained_authorize);
			$retained_authorized_info['drivers_nin']            = Input::get('authorized_nin'.$retained_authorize);
			$retained_authorized_info['drivers_license_no']     = Input::get('authorized_license_no'.$retained_authorize);
			$retained_authorized_info['drivers_street']         = Input::get('authorized_street'.$retained_authorize);
			$retained_authorized_info['drivers_city']           = Input::get('authorized_city'.$retained_authorize);
			$retained_authorized_info['drivers_po_box']         = Input::get('authorized_po_box'.$retained_authorize);
			$retained_authorized_info['drivers_country']        = Input::get('authorized_country'.$retained_authorize);
			$retained_authorized_info['drivers_cell1']          = Input::get('authorized_cell1'.$retained_authorize);
			$retained_authorized_info['drivers_cell2']          = Input::get('authorized_cell2'.$retained_authorize);
			$retained_authorized_info['drivers_email']          = Input::get('authorized_email'.$retained_authorize);
			$retained_authorized_info['drivers_driving_status'] = Input::get('authorized_driving_status'.$retained_authorize);

			Driver::find($retained_authorize)->update($retained_authorized_info);

		}
		
		//END AUTHORIZED DRIVERS
		
	
		// BEGIN NEW OWNERS
		$owners_index = Input::get('owners_index');
		$owners_index_arr = array_filter(explode(',', $owners_index));

		// LOOP THROUGH EACH OWNER AND ASSOCIATE WITH DRIVERS 
		foreach($owners_index_arr as $owners_index_id){
			$drivers_license_no = Input::get('drivers_license_no'.$owners_index_id);
			if(trim($drivers_license_no) !=""){
				$drivers_status = Driver::where('drivers_license_no', $drivers_license_no)->first();
				
				// IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($drivers_status == NULL)
				{
					
					$owner_info['drivers_fname']          = Input::get('drivers_fname'.$owners_index_id);
					$owner_info['drivers_mname']          = Input::get('drivers_mname'.$owners_index_id);
					$owner_info['drivers_lname']          = Input::get('drivers_lname'.$owners_index_id);
					$owner_info['drivers_nin']            = Input::get('drivers_nin'.$owners_index_id);
					$owner_info['drivers_license_no']     = Input::get('drivers_license_no'.$owners_index_id);
					$owner_info['drivers_street']         = Input::get('drivers_street'.$owners_index_id);
					$owner_info['drivers_city']           = Input::get('drivers_city'.$owners_index_id);
					$owner_info['drivers_po_box']         = Input::get('drivers_po_box'.$owners_index_id);
					$owner_info['drivers_country']        = Input::get('drivers_country'.$owners_index_id);
					$owner_info['drivers_cell1']          = Input::get('drivers_cell1'.$owners_index_id);
					$owner_info['drivers_cell2']          = Input::get('drivers_cell2'.$owners_index_id);
					$owner_info['drivers_email']          = Input::get('drivers_email'.$owners_index_id);
					$owner_info['drivers_driving_status'] = Input::get('drivers_driving_status'.$owners_index_id);
					

					$insert_owner_into_driver_table = Driver::create($owner_info);
					$owner_ids[] = $insert_owner_into_driver_table->id;
					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else
				{
					$owner_ids[] = Driver::where('drivers_license_no', $drivers_license_no)->first()->id;
				}
			}
				
		}
		// LINK VEHICLE WITH NEW OWNERS
		if(!empty($owner_ids)){
			foreach($owner_ids as $owner_ids_fet){
				$owner_ids_fet = (int) $owner_ids_fet;
				//VehicleDriverOwner::create(['vehicle_driver_owners_vehicle_id' => $id, 'vehicle_driver_owners_driver_id' => $owner_ids_fet]);
				Vehicle::find($id)->owners()->attach($owner_ids_fet);
			}
		}
		// END NEW OWNERS
		

		//BEGIN NEW AUTHORIZED DRIVERS
		$authorized_index = Input::get('authorized_index');

		// IF AUTHORIZED DRIVERS EXIST, ASSOCIATE WITH DRIVERS.(CHECKING USING LICENSE)
		if($authorized_index!=""){
			$authorized_index_arr = explode(',', $authorized_index);

			foreach($authorized_index_arr as $authorized_index_id){
				$authorized_license_no = Input::get('authorized_license_no'.$authorized_index_id);
				$authorized_status = Driver::where('drivers_license_no', $authorized_license_no)->first();
				

				//IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($authorized_status == NULL){

					$authorized_info['drivers_fname']          = Input::get('authorized_fname'.$authorized_index_id);
					$authorized_info['drivers_mname']          = Input::get('authorized_mname'.$authorized_index_id);
					$authorized_info['drivers_lname']          = Input::get('authorized_lname'.$authorized_index_id);
					$authorized_info['drivers_nin']            = Input::get('authorized_nin'.$authorized_index_id);
					$authorized_info['drivers_license_no']     = Input::get('authorized_license_no'.$authorized_index_id);
					$authorized_info['drivers_street']         = Input::get('authorized_street'.$authorized_index_id);
					$authorized_info['drivers_city']           = Input::get('authorized_city'.$authorized_index_id);
					$authorized_info['drivers_po_box']         = Input::get('authorized_po_box'.$authorized_index_id);
					$authorized_info['drivers_country']        = Input::get('authorized_country'.$authorized_index_id);
					$authorized_info['drivers_cell1']          = Input::get('authorized_cell1'.$authorized_index_id);
					$authorized_info['drivers_cell2']          = Input::get('authorized_cell2'.$authorized_index_id);
					$authorized_info['drivers_email']          = Input::get('authorized_email'.$authorized_index_id);
					$authorized_info['drivers_driving_status'] = Input::get('authorized_driving_status'.$authorized_index_id);


					$insert_authorized_into_driver_table = Driver::create($authorized_info);
					$authorized_ids[] = $insert_authorized_into_driver_table->id;
					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else {
					$authorized_ids[] = Driver::where('drivers_license_no', $authorized_license_no)->first()->id;
				}
			}

			// LINK VEHICLE WITH AUTHORIZED DRIVERS
			foreach($authorized_ids as $authorized_ids_fet){
				$authorized_ids_fet = (int) $authorized_ids_fet;
				//VehicleDriverAuthorized::create(['vehicle_driver_authorized_vehicle_id' => $id, 'vehicle_driver_authorized_driver_id' => $authorized_ids_fet]);
				Vehicle::find($id)->authorizedDrivers()->attach($authorized_ids_fet);
			}
		}
		// END NEW AUTHORIZED DRIVERS
		
		// BEGIN INSURANCE
		if(Input::get('insurances_company')!="")
		{

			$insurance_arr = Input::only('insurances_company', 'insurances_policy_no', 'insurances_exp_date', 'insurances_agent_fname', 'insurances_agent_lname', 'insurances_agent_cell', 'insurances_agent_city', 'insurances_agent_email');

			if(Insurance::where('insurances_vehicle_id', $id)->first()->id){
				Insurance::where('insurances_vehicle_id', $id)->update($insurance_arr);
			}else{
				//$insurance_arr['insurances_vehicle_id'] = $id;
				//Insurance::create($insurance_arr);
				Vehicle::find($id)->insurance()->save($insurance_arr);
			}
		}
		// END INSURANCE
		
		// BEGIN LIEN HOLDER
		if(Input::get('lien_index'))
		{
			$lien_arr = Input::only('liens_collateral_id', 'liens_collateral_value', 'liens_bank_name', 'liens_bank_branch', 'liens_bank_street', 'liens_bank_city');

			if(Lien::where('liens_vehicle_id', $id)->first()->id){
				Lien::where('liens_vehicle_id', $id)->update($lien_arr);
			}else {
				//$lien_arr['liens_vehicle_id'] = $id;
				//Lien::create($lien_arr);
				Vehicle::find($id)->lien()->save($lien_arr);
			}
			
			
		}
		// END LIEN HOLDER
		
		// BEGIN OLD FILES
			$old_documents_index =  Vehicle::find($id)->documents->lists('id');
			$documents_index =  explode(',', Input::get('documents_index'));
			$deleted_documents = array_diff($old_documents_index, $documents_index);
			if(!empty($deleted_documents)){
				foreach($deleted_documents as $deleted_document){
					Document::find($deleted_document)->delete();
				}
			}
		// END OLD FILES

		// BEGIN NEW FILES
		$files_col = Input::file();
		$files_count =  count(array_filter($files_col['files']));

		// IF FILES EXISTS
		if($files_count){
			foreach($files_col['files'] as $files){
				$filename_ar   = explode('.', $files->getClientOriginalName());
				$document_ext  = end($filename_ar);
				$path          = public_path().'/vehicledata/documents';
				
				// GENERATE RANDOM FILE NAME AND ADD EXTENSION
				$randName      = md5(rand() * time());
				$document_name = $randName . '.' . $document_ext;
				
				// MOVE FILE AND ENTRY INTO DATABASE
				if($files->move($path, $document_name)) {
					//Document::create(['documents_vehicle_id' => $id, 'documents_name' => $document_name]);
					Vehicle::find($id)->documents()->save(new Document(['documents_name' => $document_name]));
				}
			}
		}
		// END NEW FILES
		

		// BEGIN REGISTRATION
		if(isset($id) && $id !=""){			
			$registrations_vehicle_id       = $id;
			$registrations_no               = Input::get('registrations_no');
			$registrations_licence_plate_no = Input::get('registrations_licence_plate_no');

			if($registrations_no !="" && $registrations_licence_plate_no != "" && $registrations_vehicle_id != ""){
				
				$vehicles_use_type = Input::get('vehicles_use_type');
				$vehicles_class    = Input::get('vehicles_class');

				if($vehicles_use_type !="" && $vehicles_class !=""){
					$vehicles_use_type_table_name = VehicleUseType::find($vehicles_use_type)->vehicle_use_types_table_name;

					//REGISTRATION FEES
					$vehicles_class_col_name = $vehicles_use_type_table_name.'_total';
					$registrations_fees = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;
					
					
					$registration_ar = compact('registrations_vehicle_id', 'registrations_no', 'registrations_licence_plate_no', 'registrations_fees');
					Registration::where('registrations_vehicle_id', $id)->update($registration_ar);


					return Redirect::route('vehicle.print', [$registrations_vehicle_id]);
				}
			}
			
		}else{
			echo "Nothing is saved because fields are not filled";
			die();
		} 
		// END REGISTRATION
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function search(){
		return View::make('vehicle.search');
	}

	public function searchByReg(){
		return View::make('vehicle.search-by-reg');
	}

	public function searchSticker(){
		return View::make('vehicle.search-sticker');
	}

	public function searchUpdateVehicle(){
		return View::make('vehicle.search-update-vehicle');
	}

	public function searchVehicleHistory(){
		return View::make('vehicle.search-vehicle-history');
	}

	public function searchChangeOwner(){
		return View::make('vehicle.search-change-owner');
	}

	public function printVehicle($id){

		$vehicle = Vehicle::find($id);
		$vehicle['vehicles_class_name'] = Vehicle::vehicleClassName($id);
	

		// REGISTRATION DETAILS
		$registration = $vehicle->registration;
		$registration->reg_date = date("M dS, Y", strtotime($registration->created_at));

		//PRE-REGISTRATION VOILATIONS
		
		// VEHICLE VOILATIONS
		$vehicleVoilations = $vehicle->preRegistrationVoilations($id);
		
		if($vehicleVoilations->count()){
			$vehicleVoilationsIds = $vehicleVoilations->lists('vehicle_fine_id');
			$vehicleFines = VehicleFine::find($vehicleVoilationsIds)->sum('vehicle_fine_ammount');
		}else $vehicleFines = 0; 

		// DRIVER VOILATIONS

		$driverViolations =  $vehicle->preRegistrationDriverVoilations($id);
		if($driverViolations->count()){
			$driverVoilationsIds = $driverViolations->lists('driver_fine_id');
			$driverFines = DriverFine::find($driverVoilationsIds)->sum('driver_fine_ammount');
		}else $driverFines = 0;

		$fines = $vehicleFines+$driverFines;

		// OWNER DETAILS
		$owners = $vehicle->owners;

		//VEHICLE MODEL DETAIL
		$model = $vehicle->model;
		$css = URL::asset('assets/admin/pages/css/print.css');
		$data = compact('registration', 'vehicle', 'owners', 'model', 'css', 'fines');
		return View::make('vehicle.print', $data);
	}

	public function sticker($id){
		$vehicle = Vehicle::withTrashed()->find($id);
		if(Vehicle::vehicleStickerPrefix($id))
			$vehicle->sticker_prefix = Vehicle::vehicleStickerPrefix($id);
		$registration = $vehicle->registrationTrashed;				
		$vehicle['vehicles_class_name'] = Vehicle::vehicleClassName($id);
		$owners = $vehicle->owners;
		$authorizedDr = $vehicle->authorizedDrivers;
		$documents = $vehicle->documents;
		$insurance = $vehicle->insurance;
		$lien = $vehicle->lien;

		// BEGIN SETTING VEHICLE AND REGISTRATION STATUS 
		
		/*
		* Vehicle Status ($registration->veh_status)
		* Vehicle is new                       = 1
		* Vehicle is old and never transferred = 2
		* Vehicle has been transferred         = 3
		*     (And Not currently in use)        
		* Vehicle is old and transferred       = 4
		*     (But currently in use)
		*/
	
		/*
		* Registration Status ($registration->reg_status)
		* Sticker Never Generated = 1
		* Sticker Expired         = 2
		*/
	
		$vehilceHistory = Vehicle::getVehicleHistory($id);
		$vehicleHistoryCount = count($vehilceHistory);
		$registrations_last_renewal = $registration->registrations_last_renewal;

		// VEHICLE IS NEVER TRANSFERRED AND CURRENTLY IN USE
		if($vehicleHistoryCount == 1){
			// STICKER HAS BEEN ISSUED BEFORE
			if($registrations_last_renewal){
				// VEHICLE IS OLD
				$registration->veh_status = 2;

				//BEGIN CHECKING IF ROAD TAX EXPIRED
				$curYear = date("Y");
				$roadTaxYear =  date("Y", strtotime($registrations_last_renewal));

				// NEED TO REGISTER
				if($curYear > $roadTaxYear) $registration->reg_status = 2;
				//END CHECKING IF ROAD TAX EXPIRED

				// STICKER REGISTRATION DATE
				$registration->sticker_reg_date = date("M dS, Y", strtotime($registrations_last_renewal));
				// STICKER EXPIRY DATE
				$registration->expiry = "Dec 31st, ".date("Y", strtotime($registrations_last_renewal));
			}
			// NO STICKER HAS BEEN ISSUED BEFORE, VEHICLE IS NEW
			else{
				$registration->veh_status = 1;
				$registration->reg_status = 1;

				// CHECK IF HAS PRE REGISTRATION FINES
				$vehicleVoilations = $vehicle->voilations;
				
				if($vehicleVoilations->count()){
					$vehicleVoilationsIds = $vehicleVoilations->lists('vehicle_fine_id');
					$vehicleFines = VehicleFine::find($vehicleVoilationsIds)->sum('vehicle_fine_ammount');
				}else $vehicleFines = 0; 
				
				// DRIVER VOILATIONS

				$driverViolations =  $vehicle->driverViolations;
				if($driverViolations->count()){
					$driverVoilationsIds = $driverViolations->lists('driver_fine_id');
					$driverFines = DriverFine::find($driverVoilationsIds)->sum('driver_fine_ammount');
				}else $driverFines = 0;

				$fines = $vehicleFines+$driverFines;
				
			}
		}
		// VEHICLE HAS BEEN TRANSFERED
		else{
			$lastTransferredTo = end($vehilceHistory);
			// VEHICLE IS OLD, TRANSFERRED AND NOT CURRENTLY IN USE
			if($lastTransferredTo != $id)
				$registration->veh_status = 3;
			// VEHICLE IS OLD, TRANSFERRED AND CURRENTLY IN USE
			else {
				$registration->veh_status = 4;
				// STICKER WAS ISSUED BEFORE
				if($registrations_last_renewal){
					//BEGIN CHECKING IF ROAD TAX EXPIRED
					$curYear = date("Y");
					$roadTaxYear =  date("Y", strtotime($registrations_last_renewal));

					// NEED TO REGISTER
					if($curYear > $roadTaxYear) $registration->reg_status = 2;
					//END CHECKING IF ROAD TAX EXPIRED
					
					// STICKER REGISTRATION DATE
					$registration->sticker_reg_date = date("M dS, Y", strtotime($registrations_last_renewal));
					// STICKER EXPIRY DATE
					$registration->expiry = "Dec 31st, ".date("Y", strtotime($registrations_last_renewal));
				}
				// NO STICKER WAS ISSUED BEFORE
				else{
					$registration->reg_status = 1;
				}
			}
		}

		$data = compact('registration', 'fines', 'vehicle', 'owners', 'authorizedDr', 'documents', 'insurance', 'lien');
		return View::make('vehicle.sticker', $data);
	}

	public function printVehicleSticker($id){
		$vehicle = Vehicle::find($id);
		$vehicle['vehicles_class_name'] = Vehicle::vehicleClassName($id);



		// REGISTRATION DETAILS
		$registration = $vehicle->registration;
		if($registration->registrations_last_renewal){
			$registration->reg_date = date("M dS, Y", strtotime($registration->registrations_last_renewal));
			$registration->exp_date = "Dec 31st, ".date('Y', strtotime($registration->registrations_last_renewal));
		}

		// VOILATIONS
		
		// VEHICLE VOILATIONS
		$vehicleVoilations = $vehicle->preRegistrationVoilations($id);
		
		if($vehicleVoilations->count()){
			$vehicleVoilationsIds = $vehicleVoilations->lists('vehicle_fine_id');
			$vehicleFines = VehicleFine::find($vehicleVoilationsIds)->sum('vehicle_fine_ammount');
		}else $vehicleFines = 0; 

		// DRIVER VOILATIONS

		$driverViolations =  $vehicle->preRegistrationDriverVoilations($id);
		if($driverViolations->count()){
			$driverVoilationsIds = $driverViolations->lists('driver_fine_id');
			$driverFines = DriverFine::find($driverVoilationsIds)->sum('driver_fine_ammount');
		}else $driverFines = 0;

		$fines = $vehicleFines+$driverFines;
		

		// OWNER DETAILS
		$owners = $vehicle->owners;

		//VEHICLE MODEL DETAIL
		$model = $vehicle->model;
		$css = URL::asset('assets/admin/pages/css/print.css');

		$data = compact('registration', 'fines', 'vehicle', 'owners', 'model', 'css');
		return View::make('vehicle.print', $data);
	}
	

	public function printVehicleHistory($id){
		$vehicle = Vehicle::withTrashed()->find($id);
		$owner = $vehicle->owners->first();
		$oldVehicleIds = Vehicle::getVehicleHistory($id);


		foreach($oldVehicleIds as $oldVehicleId){
			//$oldVehicleData[] = Vehicle::withTrashed()->find($oldVehicleId);
			$vehicleFet = Vehicle::withTrashed()->find($oldVehicleId);

			// BEGIN DATA FOR FIRST TABLE (Vehicle Ownership History)
			//OWNERS
			$owner = $vehicleFet->owners->first();

			//OWNER NAME
			if($owner->drivers_mname) 
				$owners_name = $owner->drivers_fname." ".$owner->drivers_mname." ".$owner->drivers_lname;
			else
				$owners_name = $owner->drivers_fname." ".$owner->drivers_lname;
			$vehicleOwnerHistory[$owner->id]['name'] = $owners_name;

			//OWNER ADDRESS
			$vehicleOwnerHistory[$owner->id]['address'] = $owner->drivers_street." ".$owner->drivers_city." ".$owner->drivers_po_box." ".$owner->country->country_name;

			// REGISTRATION DATE
			$vehicleOwnerHistory[$owner->id]['reg_date'] = date("dS M, Y", strtotime($vehicleFet->registrationTrashed->created_at->toDateTimeString()));
			// END  DATA FOR FIRST TABLE 
			


			// BEGIN DATA FOR SECOND TABLE (Registration History)
			$registrationHistory[$vehicleFet->id]['registrations_no'] = $vehicleFet->registrationTrashed->registrations_no;
			$registrationHistory[$vehicleFet->id]['class'] = $vehicleFet->vehicleClassName($vehicleFet->id);
			$registrationHistory[$vehicleFet->id]['reg_date'] = date("dS M, Y", strtotime($vehicleFet->registrationTrashed->created_at->toDateTimeString()));
			// END DATA FOR SECOND TABLE


			// BEGIN DATA FOR THIRD TABLE (Odometer History)		
			$data = $vehicleFet->getOldOdometer->lists('created_at','log_vehicle_odometer_old_odometer');

			

			foreach($data as $odo => $date){
				
				$date = date("M dS, Y | h:i:s A", strtotime($date->toDateTimeString()));

				$odometerHistory[$date]['owners_name'] = $owners_name;
				$odometerHistory[$date]['odometer'] = $odo;
				$odometerHistory[$date]['date'] = $date;
			}
			// END DATA FOR THIRD TABLE
			
		}
		
		
		// BEGIN DATA FOR FOURTH TABLE (Vehicle Status History)
		$oldVehicleStatusAr = $vehicle->getOldVehicleStatus->lists('created_at', 'log_vehicle_status_vehicle_status_id');		

		$i = 0;
		foreach($oldVehicleStatusAr as $key => $oldVehicleStatusDate){
			if($key != 1 && $key != 2){
				$oldVehicleStatus[$i]['status'] = VehicleStatus::find($key)->vehicle_status_name;
				$oldVehicleStatus[$i]['date'] = date("M dS, Y | h:i:s A", strtotime($oldVehicleStatusDate->toDateTimeString()));
				$i++;
			}
		}		

		// END DATA FOR FOURTH TABLE

		
		// BEGIN DATA FOR FIFTH TABLE (Voilations)
		$voilations = Vehicle::withTrashed()->find($id)->voilations;
		foreach($voilations as $voilation){
			//echo "<pre>";
			//print_r($voilation->created_at);
			$year = Date("Y", strtotime($voilation->created_at->toDateTimeString()));
			if($year != 1970 && $year != "-0001")
				$voilation->date = Date("M dS, Y", strtotime($voilation->created_at->toDateTimeString()));
			else $voilation->date = "Not Available";
			
		}
		// END DATA FOR FIFTH TABLE

		if(!isset($odometerHistory)) $odometerHistory = "";
		if(!isset($oldVehicleStatus)) $oldVehicleStatus = "";

		$data = compact('vehicle', 'vehicleOwnerHistory', 'registrationHistory', 'odometerHistory', 'oldVehicleStatus', 'voilations');

		return View::make('vehicle.history-vehicle', $data);
	}

	
	/**
	 * This function is responsible for all the data that is 
	 * needed by different pages viaajax
	 * 
	 * @return Depends on what what is being called 
	 */
	public function data(){
		// BEGIN CHECK VEHICLE VIN
		if( isset($_POST['vehicles_vin']) && $_POST['vehicles_vin'] != "" ){
			$vehicles_vin = $_POST['vehicles_vin'];
			$vehicles_vin_status = Vehicle::where('vehicles_vin', $vehicles_vin)->withTrashed()->get()->count();
			
			if($vehicles_vin_status > 0) return 1;
		}
		// END CHECK VEHICLE VIN
		

		// BEGIN CHECK VEHICLE LIC NO
		if( isset($_POST['registrations_licence_plate_no']) && $_POST['registrations_licence_plate_no'] != "" ){
			$registrations_licence_plate_no = $_POST['registrations_licence_plate_no'];
			$registrations_licence_plate_no_status = Registration::withTrashed()->where('registrations_licence_plate_no', $registrations_licence_plate_no)->get()->count();
			
			if($registrations_licence_plate_no_status > 0) return 1;
		}
		// END CHECK VEHICLE LIC NO
		

		// BEGIN SHOW ALL MAKES (USER CLICKED ON YEAR)
		if( isset($_POST['inp']) && $_POST['inp'] == 1 ){
			/* REMOVE TO SHOW ALL MODELS
				$model_make_ar = ['-1' => 'Select Make'] + Model::distinct()->orderBy('model_make_id')->lists('model_make_id', 'model_make_id');
			*/

			$vehicles_year = $_POST['vehicles_year'];
			$model_make_ar = ['-1' => 'Select Make'] + Model::where('model_year', $vehicles_year)->distinct()->orderBy('model_make_id')->lists('model_make_id', 'model_make_id');
			$model_make_ar['add_new'] = "Add New";

			foreach($model_make_ar as $model_make_ar_fet) 
				echo "<option value='$model_make_ar_fet'>$model_make_ar_fet</option>";
			
		}
		// END SHOW ALL MAKES (USER CLICKED ON YEAR)

		// BEGIN SHOW ALL ASSOCIATED MODELS NAME AND TRIM (USER CLICKED ON MAKE)
		if( isset($_POST['inp']) && $_POST['inp'] == 2 ){

			$vehicles_year = $_POST['vehicles_year'];
			$vehicles_make_id = $_POST['vehicles_make_id'];			

			$vehicles_name_trim_arr = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->get(['model_name', 'model_trim'])->toArray();

			foreach($vehicles_name_trim_arr as $vehicles_name_trim_arr_fet){
				$vehicles_name_trim[] = implode(', ', $vehicles_name_trim_arr_fet);
			}

			$vehicles_name_trim = array_unique($vehicles_name_trim);
			sort($vehicles_name_trim);
			
			$firstOp = "<option value='-1'>Select Model</option>";
			echo $firstOp;
			
			foreach($vehicles_name_trim as $vehicles_name_trim_fet) 
				echo "<option value='$vehicles_name_trim_fet'>$vehicles_name_trim_fet</option>";
		}
		// BEGIN SHOW ALL ASSOCIATED MODELS NAME AND TRIM (USER CLICKED ON MAKE)
		
		// BEGIN SHOW ALL ASSOCIATED BODY STYLE (USER CLICKED ON MODEL)
		if( isset($_POST['inp']) && $_POST['inp'] == 3 ){
			
			$vehicles_year = $_POST['vehicles_year'];
			$vehicles_make_id = $_POST['vehicles_make_id'];

			$vehicles_name_trim = $_POST['vehicles_name_trim'];
			$vehicles_name_trim_ar = explode(',', $vehicles_name_trim);

			
			$model_name = trim($vehicles_name_trim_ar[0]);
			$model_trim = trim($vehicles_name_trim_ar[1]);


			$vehicles_body_ar = array_filter(array_unique(Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->lists('model_body')));

			sort($vehicles_body_ar);

			$firstOp = "<option value='-1'>Select Body Style</option>";
			echo $firstOp;

			foreach($vehicles_body_ar as $vehicles_body)
				echo "<option value='$vehicles_body'>$vehicles_body</option>";
			
		}
		// END SHOW ALL ASSOCIATED BODY STYLE (USER CLICKED ON MODEL)
		
		
		// BEGIN SHOW ASSOCIATED BODY WEIGHT (USER CLICKED ON BODY STYLE) 
		// ALSO RESPONSIBLE FOR REPLYING TO AJAX REQUEST WHEN USER CLICKED ON MODEL
		if( isset($_POST['inp']) && $_POST['inp'] == 4 ){
			$vehicles_year         = $_POST['vehicles_year'];
			$vehicles_make_id      = $_POST['vehicles_make_id'];			
			$vehicles_name_trim    = $_POST['vehicles_name_trim'];
			$vehicles_name_trim_ar = explode(',', $vehicles_name_trim);
			$model_name            = trim($vehicles_name_trim_ar[0]);
			$model_trim            = trim($vehicles_name_trim_ar[1]);

			// USER CLICKED ON MODEL
			if(!isset($_POST['vehicles_body'])){
				$model_weight_kg_ar = array_filter(array_unique(Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_year', $vehicles_year)->lists('model_weight_kg')));

				if(!empty($model_weight_kg_ar)){
					sort($model_weight_kg_ar);
					
					$firstOp = "<option value='-1'>Select Gross Weight</option>";
					echo $firstOp;

					foreach($model_weight_kg_ar as $model_weight_kg_ar_fet) echo "<option value='$model_weight_kg_ar_fet'>$model_weight_kg_ar_fet</option>";
				}else {
					return 0;
				}

			}
			// USER CLICKED ON BODY STYLE
			else {
				$vehicles_body = $_POST['vehicles_body'];
				$model_weight_kg_ar = array_filter(array_unique(Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->where('model_year', $vehicles_year)->lists('model_weight_kg')));
				
				if(!empty($model_weight_kg_ar)){
					sort($model_weight_kg_ar);
				
					$firstOp = "<option value='-1'>Select Gross Weight</option>";
					echo $firstOp;

					foreach($model_weight_kg_ar as $model_weight_kg_ar_fet) echo "<option value='$model_weight_kg_ar_fet'>$model_weight_kg_ar_fet</option>";
				}else {
					return 0;
				}
			}
		}
		// END SHOW ASSOCIATED BODY WEIGHT (USER CLICKED ON BODY STYLE)

		// BEGIN CLICK ON VEHICLE USE TYPE
		if( isset($_POST['inp']) && $_POST['inp'] == 5 ){
			$vehicles_use_type = $_POST['vehicles_use_type'];
			$vehicles_weight_kg = $_POST['vehicles_weight_kg'];

			// BEGIN SWITCH TO SWITCH BETWEEN DIFFERENT VEHICLE USE TYPES (EXCEPT COMMERCIAL - PASSENGER)
			switch($vehicles_use_type){
				//NONE SELECTED
				case -1:
					$firstOp = "<option value='-1'>Select Class</option>";
					echo $firstOp;
					break;

				// BEGIN COMMERCIAL OWN GOODS VEHICLE
				case 3:
					// CHECK VALUES BETWEEN MIN AND MAX WEIGHT
					$vehicle_class_ar = FeesCommercialOwnGood::whereRaw('? BETWEEN coalesce(`fees_commercial_own_goods_min_kg`) AND coalesce(`fees_commercial_own_goods_max_kg`, ?)', [$vehicles_weight_kg, 10000])->lists('fees_commercial_own_goods_class', 'id');

					foreach($vehicle_class_ar as $id => $vehicle_class_ar_fet) 
						echo "<option value='$id'>$vehicle_class_ar_fet</option>";
					break;
				// END COMMERCIAL OWN GOODS VEHICLE
				
				
				// BEGIN MOTORCYCLE
				case 8:
					$vehicle_class_ar = FeesMotorcycle::lists('fees_motorcycle_class', 'id');
					$firstOp = "<option value='-1'>Select Class</option>";
					asort($vehicle_class_ar);
					echo $firstOp;

					foreach($vehicle_class_ar as $id => $vehicle_class_ar_fet) echo "<option value='$id'>$vehicle_class_ar_fet</option>";
					break;	
				// END MOTORCYCLE	

				// BEGIN PRIVATE NGO, GG/MUNICIPALITY, COMPANYRENTAL AND RENTAL
				default:
					if($vehicles_weight_kg != -1){

						// CHECK VALUES BETWEEN MIN AND MAX WEIGHT
						$vehicle_class_ar = FeesPrivate::whereRaw('? BETWEEN coalesce(`fees_private_min_kg`) AND coalesce(`fees_private_max_kg`, ?)', [$vehicles_weight_kg, 10000])->lists('fees_private_class', 'id');
						foreach($vehicle_class_ar as $id => $vehicle_class_ar_fet) 
							echo "<option value='$id'>$vehicle_class_ar_fet</option>";
					}
				// END PRIVATE NGO, GG/MUNICIPALITY, COMPANYRENTAL AND RENTAL
			}
			// END SWITCH TO SWITCH BETWEEN DIFFERENT VEHICLE USE TYPES (EXCEPT COMMERCIAL - PASSENGER)
		}
		// END CLICK ON VEHICLE USE TYPE
		
		// BEGIN CLICK ON VEHICLE USE TYPE(COMMERCIAL PASSENGERS)
		if( isset($_POST['inp']) && $_POST['inp'] == 6 ){
			$vehicle_class_ar = FeesCommercialPassenger::lists('fees_commercial_passengers_no_of_passenger', 'id');
			$firstOp = "<option value='-1'>Select No. Of Passengers</option>";
			ksort($vehicle_class_ar);
			echo $firstOp;

			foreach($vehicle_class_ar as $id => $vehicle_class_ar_fet) echo "<option value='$id'>$vehicle_class_ar_fet</option>";
		}
		// END CLICK ON VEHICLE USE TYPE(COMMERCIAL PASSENGERS)
		
		
		// BEGIN CLICK ON NO. OF PASSENGERS
		if( isset($_POST['inp']) && $_POST['inp'] == 7 ){
			$vehicles_no_of_passengers = $_POST['vehicles_no_of_passengers'];

			$vehicle_class_ar = FeesCommercialPassenger::where('id', $vehicles_no_of_passengers)->lists('fees_commercial_passengers_class', 'id');
			foreach($vehicle_class_ar as $id => $vehicle_class_ar_fet) echo "<option value='$id'>$vehicle_class_ar_fet</option>";
		}
		// END CLICK ON NO. OF PASSENGERS
		
		// BEGIN AJAX REQUEST TO GENERATE REGISTRATION NO. (MODEL ALREADY IN DB)
		if( isset($_POST['inp']) && $_POST['inp'] == 8 ){
			
			$vehicles_make_id      = trim(Input::get('vehicles_make_id'));
			$vehicles_name_trim    = trim(Input::get('vehicles_name_trim'));
			$vehicles_name_trim_ar = explode(',', $vehicles_name_trim);
			$model_name            = trim($vehicles_name_trim_ar[0]);
			$model_trim            = trim($vehicles_name_trim_ar[1]);
			$vehicles_body         = trim(Input::get('vehicles_body'));
			$vehicles_weight_kg    = trim(Input::get('vehicles_weight_kg'));
			$new_wt                = (int) Input::get('new_wt');
			
			$vehicles_year = trim(Input::get('vehicles_year'));
			$vehicles_use_type = Input::get('vehicles_use_type');
			$vehicles_class = Input::get('vehicles_class');
			$vehicles_class_abbr = trim(Input::get('vehicles_class_abbr'));

			
			// IF DEFAULT WEIGHT IS PRESENT
			if($new_wt){
				// IF MODEL HAS BODY
				if($vehicles_body)
					$model = Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->whereNull('model_weight_kg')->first();
				else
					$model = Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->whereNull('model_body')->whereNull('model_weight_kg')->first();
			}
			//USER HAS ENTERED MANUAL WEIGHT
			else{
				// IF MODEL HAS BODY
				if($vehicles_body)
					$model = Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->where('model_weight_kg', $vehicles_weight_kg)->first();
				else
					$model = Model::where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->whereNull('model_body')->where('model_weight_kg', $vehicles_weight_kg)->first();
			}

			$model_year = $model->model_year;
			$model_make_id = strtoupper(substr($model->model_make_id, 0, 4));

			$year = date("Y");

			$class_sequence =  Vehicle::vehicleRegistrationSequence($vehicles_use_type, $vehicles_class);

			//$class_sequence =  str_pad(Vehicle::withTrashed()->where('vehicles_use_type', $vehicles_use_type)->where('vehicles_class', $vehicles_class)->count()+1, 7, 0, STR_PAD_LEFT);

			return $vehicles_class_abbr."-".$year."-".$model_year."-".$model_make_id."-".$class_sequence;
		
		}
		// END AJAX REQUEST TO GENERATE REGISTRATION NO. (MODEL ALREADY IN DB)
		

		// BEGIN AJAX REQUEST TO GENERATE REGISTRATION NO. (NEW MODEL)
		if( isset($_POST['inp']) && $_POST['inp'] == 9 ){
			$vehicles_make_id = strtoupper(substr(trim(Input::get('vehicles_make_id')), 0, 4));
			$vehicles_year = trim(Input::get('vehicles_year'));
			$vehicles_use_type = Input::get('vehicles_use_type');
			$vehicles_class = Input::get('vehicles_class');
			$vehicles_class_abbr = trim(Input::get('vehicles_class_abbr'));

			$year = date("Y");

			$class_sequence =  Vehicle::vehicleRegistrationSequence($vehicles_use_type, $vehicles_class);
			//$class_sequence =  str_pad(Vehicle::withTrashed()->where('vehicles_use_type', $vehicles_use_type)->where('vehicles_class', $vehicles_class)->count()+1, 7, 0, STR_PAD_LEFT);

			return $registration_number = $vehicles_class_abbr."-".$year."-".$vehicles_year."-".$vehicles_make_id."-".$class_sequence;
		}
		// END AJAX REQUEST TO GENERATE REGISTRATION NO. (NEW MODEL)
		
		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING REGISTRATION NO. (vehicle.search, vehicle.search-by-reg)
		if(isset($_POST['registrations_no']) && $_POST['registrations_no'] != ""){
			$registrations_no = $_POST['registrations_no'];
			$vehicles_id_count = Registration::withTrashed()->where('registrations_no', $registrations_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::withTrashed()->where('registrations_no', $registrations_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::withTrashed()->find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				$url = URL::route('vehicle.edit', [$vehicles_id]);
				$urlShow = URL::route('vehicle.show', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$urlShow>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$urlShow class='btn default btn-xs purple'>
						<i class='fa fa-edit'></i>Details</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING REGISTRATION NO.
		
		// BEGIN AJAX REQUEST TO SHOW VEHICLE HISTORY SEARCHED BY USING REGISTRATION NO. TO VIEW ITS HISTORY (vehicle.search-vehicle-history)
		if(isset($_POST['registrations_no_search_history']) && $_POST['registrations_no_search_history'] != ""){
			$registrations_no = $_POST['registrations_no_search_history'];
			$vehicles_id_count = Registration::where('registrations_no', $registrations_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::where('registrations_no', $registrations_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				
				//$urlShow = URL::route('vehicle.show', [$vehicles_id]);
				$urlHistory = URL::route('print.vehicle.history', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$urlHistory>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$urlHistory class='btn default btn-xs purple'>
						</i>History</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE HISTORY SEARCHED BY USING REGISTRATION NO.
		

		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING REGISTRATION NO. TO CHANGE ITS OWNER (vehicle.search-change-owner)
		if(isset($_POST['registrations_no_change_owner']) && $_POST['registrations_no_change_owner'] != ""){
			$registrations_no = $_POST['registrations_no_change_owner'];
			$vehicles_id_count = Registration::where('registrations_no', $registrations_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::where('registrations_no', $registrations_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				
				
				$url = URL::route('change.owner.edit', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$url>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$url class='btn default btn-xs purple'>
						</i>Change Owner</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE HISTORY SEARCHED BY USING REGISTRATION NO.
		

		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING REGISTRATION NO. TO UPDATE IT (vehicle.search-vehicle-update)
		if(isset($_POST['registrations_no_search_update']) && $_POST['registrations_no_search_update'] != ""){
			$registrations_no = $_POST['registrations_no_search_update'];
			$vehicles_id_count = Registration::where('registrations_no', $registrations_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::where('registrations_no', $registrations_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				
				
				$url = URL::route('vehicle.edit', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$url>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$url class='btn default btn-xs purple'>
						</i>Update Vehicle</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE HISTORY SEARCHED BY USING REGISTRATION NO.
		

		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING REGISTRATION NO. TO EDIT/UPDATE STICKER (vehicle.search-sticker)
		if(isset($_POST['registrations_no_update_sticker']) && $_POST['registrations_no_update_sticker'] != ""){
			$registrations_no = $_POST['registrations_no_update_sticker'];
			$vehicles_id_count = Registration::where('registrations_no', $registrations_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::where('registrations_no', $registrations_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				
				
				$url = URL::route('vehicle.sticker', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$url>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$url class='btn default btn-xs purple'>
						</i>Issue/Renew Sticker</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE HISTORY SEARCHED BY USING REGISTRATION NO. 
		
		
		 
		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING LICENSE PLATE NO (vehicle.search)
		if(isset($_POST['registrations_licence_plate_no_search']) && $_POST['registrations_licence_plate_no_search'] != ""){

			$registrations_licence_plate_no = $_POST['registrations_licence_plate_no_search'];
			$vehicles_id_count = Registration::withTrashed()->where('registrations_licence_plate_no', $registrations_licence_plate_no)->count();

			if($vehicles_id_count != 0){
				$vehicles_id =  Registration::withTrashed()->where('registrations_licence_plate_no', $registrations_licence_plate_no)->first()->registrations_vehicle_id;

				$vehicles = Vehicle::withTrashed()->find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				$url = URL::route('vehicle.edit', [$vehicles_id]);
				$urlShow = URL::route('vehicle.show', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$urlShow>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$url class='btn default btn-xs purple'>
						<i class='fa fa-edit'></i>Edit</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING LICENSE PLATE NO
		
		
		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING DRIVER NIN (vehicle.search)
		if(isset($_POST['owners_nin_search']) && $_POST['owners_nin_search'] != ""){

			$owners_nin = $_POST['owners_nin_search'];
			$owner = Driver::where('drivers_nin', $owners_nin)->first();

			// DRIVER EXISTS
			if($owner){
				
				//$owner->id;

				$vehicles = $owner->vehicleOwnerTransferred;
				
				if($vehicles->count() > 0){

					$row = "";
					foreach($vehicles as $vehicle){
						$vehicles_id = $vehicle->id;
						$vehicles_vin = $vehicle->vehicles_vin;
						$model_make_id =  $vehicle->model->model_make_id;
						$model_name = $vehicle->model->model_name;
						$vehicle_use_types_name = $vehicle->vehicleUseType->vehicle_use_types_name;
						$urlShow = URL::route('vehicle.show', [$vehicles_id]);
						$url = URL::route('vehicle.edit', [$vehicles_id]);

						
						$row .= "<tr>";
						$row .= "<td><a href=$urlShow>$vehicles_vin</a></td>";
						$row .= "<td>$model_make_id</td>";
						$row .= "<td>$model_name</td>";
						$row .= "<td>$vehicle_use_types_name</td>";
						$row .= "<td><a href=$url class='btn default btn-xs purple'>
								<i class='fa fa-edit'></i>Edit</a></td>";
						$row .= "</tr>";
					}
					return $row;
				}
			}
		}
		// END AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING DRIVER NIN
	
		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING STICKER (vehicle.search)
		if(isset($_POST['registrations_sticker_serial_no_search']) && $_POST['registrations_sticker_serial_no_search'] !=""){

			$registrations_sticker_serial_no = $_POST['registrations_sticker_serial_no_search'];
			$regRow = Registration::withTrashed()->where('registrations_sticker_serial_no', $registrations_sticker_serial_no)->first();
			if($regRow){

				$vehicles_id = $regRow->vehicle->id;
				$vehicles_vin = $regRow->vehicle->vehicles_vin;
				$model_make_id =  $regRow->vehicle->model->model_make_id;
				$model_name = $regRow->vehicle->model->model_name;
				$vehicle_use_types_name = $regRow->vehicle->vehicleUseType->vehicle_use_types_name;
				$urlShow = URL::route('vehicle.show', [$vehicles_id]);
				$url = URL::route('vehicle.edit', [$vehicles_id]);


				$row = "";
				$row .= "<tr>";
				$row .= "<td><a href=$urlShow>$vehicles_vin</a></td>";
				$row .= "<td>$model_make_id</td>";
				$row .= "<td>$model_name</td>";
				$row .= "<td>$vehicle_use_types_name</td>";
				$row .= "<td><a href=$url class='btn default btn-xs purple'>
						<i class='fa fa-edit'></i>Edit</a></td>";
				$row .= "</tr>";

				return $row;
			}

		}
		// END AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING STICKER

		// BEGIN AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING COLLATERAL ID (vehicle.search)
		if(isset($_POST['liens_collateral_id_search']) && $_POST['liens_collateral_id_search'] != ""){

			$liens_collateral_id = $_POST['liens_collateral_id_search'];
			
			$lien_id_count = Lien::where('liens_collateral_id', $liens_collateral_id)->count();

			if($lien_id_count != 0){
				$lien = Lien::where('liens_collateral_id', $liens_collateral_id)->first();
				$vehicle = $lien->vehicle;

				$vehicles_id = $vehicle->id;

				$vehicles = Vehicle::find($vehicles_id);
				$vehicles_vin = $vehicles->vehicles_vin;
				$vehicles_model_id = $vehicles->vehicles_model_id;
				$vehicles_use_type_id = $vehicles->vehicles_use_type;

				$model = Model::find($vehicles_model_id);
				$model_make_id = $model->model_make_id;
				$model_name = $model->model_name;

				$vehicle_use_types_name = VehicleUseType::find($vehicles_use_type_id)->vehicle_use_types_name;

				$url = URL::route('vehicle.edit', [$vehicles_id]);
				$urlShow = URL::route('vehicle.show', [$vehicles_id]);

				echo "<tr>";
				echo "<td><a href=$urlShow>$vehicles_vin</a></td>";
				echo "<td>$model_make_id</td>";
				echo "<td>$model_name</td>";
				echo "<td>$vehicle_use_types_name</td>";
				echo "<td><a href=$url class='btn default btn-xs purple'>
						<i class='fa fa-edit'></i>Edit</a></td>";
				echo "</tr>";
						

			}else return 0;
		}
		// END AJAX REQUEST TO SHOW VEHICLE SEARCHED BY USING COLLATERAL ID
	
		
		
		// BEGIN AJAX REQUEST TO CHECK IF FINES ARE ASSOCIATED WITH THE VEHICLE (FROM vehicle.show.blade.php)
		if(isset($_POST['vehicle_associated_fines']) && $_POST['vehicle_associated_fines'] !=""){
			//VEHICLE ID
			$vehicle_id = $_POST['vehicle_associated_fines'];
			return Vehicle::getVehiclePendingFinesMessage($vehicle_id);
			
		}
		// END AJAX REQUEST TO CHECK IF FINES ARE ASSOCIATED WITH THE VEHICLE (FROM vehicle.show.blade.php)
		

		// BEGIN AJAX REQUEST TO ADD NEW STICKER AND UPDATE ODOMETER (FROM vehicle.show.blade.php)
		if(isset($_POST['registrations_sticker_serial_no']) && $_POST['registrations_sticker_serial_no'] !=""){
			// VEHICLE ID
			$vehicles_id = trim($_POST['vehicles_id']);
			$registrations_sticker_serial_no = trim($_POST['registrations_sticker_serial_no']);
			

			// TAKE OLD ODOMETER IN LOG AND Update Odometer(Coming from registration renewal)
			if(isset($_POST['vehicles_odometer']) && $_POST['vehicles_odometer'] !=0){
				$vehicles_odometer = $_POST['vehicles_odometer'];
				LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $vehicles_id, 'log_vehicle_odometer_old_odometer' => $vehicles_odometer, 'log_vehicle_odometer_sticker' => $registrations_sticker_serial_no, 'log_vehicle_odometer_status' => 3]);
				Vehicle::find($vehicles_id)->update(['vehicles_odometer' => $vehicles_odometer]);

			}
			// VEHILE IS REGISTERING FOR FIRST TIME (Could be transferred one registering first time after transfer)
			else{
				$logRow = LogVehicleOdometer::where('log_vehicle_odometer_vehicle_id', $vehicles_id)->where('log_vehicle_odometer_status', 1)->first();
				$logRow->log_vehicle_odometer_sticker = $registrations_sticker_serial_no;
				$logRow->save();

				//MARK FINES AS PAID(CASE IN WHICH VEHICLE STICKER IS BEING GENERATED FOR A VEHICLE WITH PRE-REGISTRATION FINES)
				
				//VEHICLE FINES
				$vehicleVoilations = ViolateVehicle::where('vehicle_id', $vehicles_id)->where('status', 2);	
				if($vehicleVoilations->count())
					$vehicleVoilations->update(['status'=> 1]);

				//DRIVER FINES
				$driverVoilations = ViolateDriver::where('vehicle_id', $vehicles_id)->where('status', 2);
				if($driverVoilations->count())
					$driverVoilations->update(['status' => 1]);
				
			}


			return Registration::registerSticker($vehicles_id, $registrations_sticker_serial_no);
		}
		// END AJAX REQUEST TO ADD NEW STICKER
		
		// BEGIN AJAX REQUEST TO CHECK IF STICKER IS ALREADY PRESENT
		if(Input::get('inp') == 10){
			$registrations_sticker_serial_no = Input::get('sticker_no');
			$reg_check1 =  Registration::where('registrations_sticker_serial_no', $registrations_sticker_serial_no)->first();
			if($reg_check1) return $reg_check1;
			else{
				return LogVehicleOdometer::where('log_vehicle_odometer_sticker', $registrations_sticker_serial_no)->first();
			}
		}
		// END AJAX REQUEST TO CHECK IF STICKER IS ALREADY PRESENT
		 
		// BEGIN AJAX REQUEST TO CHECK IF NIN ALREADY IN DATABASE
		if(Input::get('inp') == 11){
			$old_drivers_nin_val_new = Input::get('old_drivers_nin_val_new');
			$owner = Driver::where('drivers_nin', $old_drivers_nin_val_new)->first();

			if($owner){
				if($owner->drivers_mname) 
					$owners_name = $owner->drivers_fname." ".$owner->drivers_mname." ".$owner->drivers_lname;
				else
					$owners_name = $owner->drivers_fname." ".$owner->drivers_lname;

				$url = URL::route('driver.history', [$owner->id]);

				return "NIN already registered to <a href=$url>$owners_name</a>";
			}
		}
		// END AJAX REQUEST TO CHECK IF NIN ALREADY IN DATABASE
		

		// BEGIN AJAX REQUEST TO CHECK IF Driver LICENSE NUMBER ALREADY IN DATABASE
		if(Input::get('inp') == 12){
			$old_drivers_license_no_val_new = Input::get('old_drivers_license_no_val_new');
			$owner = Driver::where('drivers_license_no', $old_drivers_license_no_val_new)->first();

			if($owner){
				if($owner->drivers_mname) 
					$owners_name = $owner->drivers_fname." ".$owner->drivers_mname." ".$owner->drivers_lname;
				else
					$owners_name = $owner->drivers_fname." ".$owner->drivers_lname;

				$url = URL::route('driver.history', [$owner->id]);
				return "License already registered to <a href=$url>$owners_name</a>";
			}
		}
		// END AJAX REQUEST TO CHECK IF Driver LICENSE NUMBER ALREADY IN DATABASE
		
	}

	/**
	 * Showing From For Changing vehicle Owner
	 * @param  int $id Id of vehicle whose owner is being changed.
	 * @return view     Form that shows old data and collects data of new owner.
	 */
	public function changeOwnerEdit($id){
		$vehicle = Vehicle::find($id);

		// BEGIN ALL DATA NEEDED BY EDIT FORM
		$vehicleData = Vehicle::vehicleData($id);

		// IF VEHICLE USE TYPE IS COMMERCIAL PASSENGERS
		if($vehicleData->vehicles_use_type == 2) {
			$noOfPas = Vehicle::noOfPassengers($id);
		}//else $noOfPas = "";

		// GENERIC DATA
		$pendingFinesMsg       = Vehicle::getVehiclePendingFinesMessage($id);
		$vehicleStatus         = VehicleStatus::listVehicleStatus();
		$colorList             = Color::listColors();
		$vehicleUseType        = VehicleUseType::listVehicleUseTypes();
		$country               = Country::listCountries();
		$drivingStatusName     = DrivingStatus::lists('driving_status_name', 'id');
		
		$registrationNoUpdated = Vehicle::registrationNoUpdated($id);
		$insurance             = $vehicle->insurance;
		$lien                  = $vehicle->lien;

		// END ALL DATA NEEDED BY REGISTRATION FORM

		//MAKING AN ARRAY OF DATA THAT IS NEEDED IN FORM
		$data = compact('vehicleData', 'pendingFinesMsg' , 'noOfPas', 'vehicleStatus', 'colorList', 'vehicleUseType', 'country', 'drivingStatusName', 'registrationNoUpdated', 'insurance', 'lien');

		return View::make('vehicle.change-owner', $data);
	}

	public function changeOwnerUpdate($id){
		// FIND OLD VEHICLE AND CREATE RESPECTIVE LOGS
		$oldVehicle = Vehicle::find($id);

	/*
		// IF VEHICLE STATUS IS CHANGED, ADD OLD STATUS IN LOG AND UPDATE DATA
		if($oldVehiclesStatus != $newVehiclesStatus){
			LogVehicleStatus::create(['log_vehicle_status_vehicle_id' => $id, 'log_vehicle_status_vehicle_status_id' => $oldVehiclesStatus]);
		}

		// IF VEHICLE COLOR IS CHANGED, ADD OLD COLOR IN LOG AND UPDATE DATA
		if($oldvehicleColor != $newVehicleColor){
			LogVehicleColor::create(['log_vehicle_color_vehicle_id' => $id, 'log_vehicle_color_color_id' => $oldvehicleColor]);
		}

		// IF VEHICLE USE TYPE IS CHANGED, ADD OLD USE TYPE IN LOG AND UPDATE DATA
		if($oldVehicleUseType != $newVehicleUseType){
			$oldRegistrations_no = $oldVehicle->registration->registrations_no;
			LogVehicleUseType::create(['log_vehicle_use_type_vehicle_id' => $id, 'log_vehicle_use_type_use_type' => $oldVehicleUseType, 'log_vehicle_use_type_registration_no' => $oldRegistrations_no]);
		}
	
	*
		// TAKE LOG OF ODOMETER
		$vehicles_odometer = trim(Input::get('vehicles_odometer'));
		$oldOdometer = Vehicle::find($id)->vehicles_odometer;
		LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $id, 'log_vehicle_odometer_old_odometer' => $oldOdometer]);
	*/


		//VEHICLE DATA
		$vehicles_year         = trim(Input::get('vehicles_year'));
		$vehicles_make_id      = trim(Input::get('vehicles_make_id'));

		$vehicles_name_trim    = trim(Input::get('vehicles_name_trim'));
		$vehicles_name_trim_ar = explode(',', $vehicles_name_trim);
		$model_name            = trim($vehicles_name_trim_ar[0]);

		if(count($vehicles_name_trim_ar) > 1)
			$model_trim            = trim($vehicles_name_trim_ar[1]);
		else $model_trim = "";

		$vehicles_body         = trim(Input::get('vehicles_body'));
		if($vehicles_body == -1) $vehicles_body = "";
		$vehicles_weight_kg    = trim(Input::get('vehicles_weight_kg'));

		
		// BEGIN VEHICLE

		// IF VEHICLE BODY IS NOT BLANK THEN ADD BODY, ELSE IGNORE IT TO MAKE IT NULL
		if($vehicles_body != ""){
			$vehicle = Input::only(['vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_body', 'vehicles_weight_kg', 'vehicles_use_type', 'vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer']);
		}else {
			$vehicle = Input::only(['vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_weight_kg', 'vehicles_use_type', 'vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer']);
		}
		
		//$validator_vehicle = Validator::make($vehicle, Vehicle::$rules);

		//if($validator_vehicle->passes()){
			// GETTING AND ADDING MODEL ID
			
			// IF BODY IS NULL
			if($vehicles_body == ""){
				// GETTING MODEL
				$vehicle['vehicles_model_id'] = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->whereNull('model_body')->first()->id;
			}else {
				$vehicle['vehicles_model_id'] = Model::where('model_year', $vehicles_year)->where('model_make_id', $vehicles_make_id)->where('model_name', $model_name)->where('model_trim', $model_trim)->where('model_body', $vehicles_body)->first()->id;
			}
			

			// INSERT VEHICLE DATA AND GET ID
			$vehicle_inserted_id = Vehicle::create($vehicle)->id;


		//}else
		//	return Redirect::route('vehicle.create')->withErrors($validator_vehicle)->withInput();
		
		// END VEHICLE
		
		// ASSOCTIATE NEW VEHICLE AND THEN DELETE OLD VEHICLE DATA
		$old_vehicle = Vehicle::find($id);

		// ASSOCIATE NEW VEHICLE WITH OLD VEHICLE
		$old_vehicle->update(['vehicles_transfer' => $vehicle_inserted_id]);

		// DELETE INSURANCE
		if($old_vehicle->insurance)
			$old_vehicle->insurance->delete();
		// DELETE LIEN
		if($old_vehicle->lien)
			$old_vehicle->lien->delete();
		// DELETE REGISTRATION
		$old_vehicle->registration->delete();
		// DELETE VEHICLE
		$old_vehicle->delete();

		// BEGIN OWNERS
		$owners_index = Input::get('owners_index');
		$owners_index_arr = array_filter(explode(',', $owners_index));
		
		// LOOP THROUGH EACH OWNER AND ASSOCIATE WITH DRIVERS
		foreach($owners_index_arr as $owners_index_id){
			$drivers_license_no = Input::get('drivers_license_no'.$owners_index_id);
			if(trim($drivers_license_no) !=""){
				$drivers_status = Driver::where('drivers_license_no', $drivers_license_no)->first();
				
				// IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($drivers_status == NULL)
				{
					
					$owner_info['drivers_fname']          = Input::get('drivers_fname'.$owners_index_id);
					$owner_info['drivers_mname']          = Input::get('drivers_mname'.$owners_index_id);
					$owner_info['drivers_lname']          = Input::get('drivers_lname'.$owners_index_id);
					$owner_info['drivers_nin']            = Input::get('drivers_nin'.$owners_index_id);
					$owner_info['drivers_license_no']     = Input::get('drivers_license_no'.$owners_index_id);
					$owner_info['drivers_street']         = Input::get('drivers_street'.$owners_index_id);
					$owner_info['drivers_city']           = Input::get('drivers_city'.$owners_index_id);
					$owner_info['drivers_po_box']         = Input::get('drivers_po_box'.$owners_index_id);
					$owner_info['drivers_country']        = Input::get('drivers_country'.$owners_index_id);
					$owner_info['drivers_cell1']          = Input::get('drivers_cell1'.$owners_index_id);
					$owner_info['drivers_cell2']          = Input::get('drivers_cell2'.$owners_index_id);
					$owner_info['drivers_email']          = Input::get('drivers_email'.$owners_index_id);
					$owner_info['drivers_driving_status'] = Input::get('drivers_driving_status'.$owners_index_id);


					$insert_owner_into_driver_table = Driver::create($owner_info);
					$owner_ids[] = $insert_owner_into_driver_table->id;
					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else
				{
					$owner_ids[] = Driver::where('drivers_license_no', $drivers_license_no)->first()->id;
				}
			}
				
		}

		// LINK VEHICLE WITH OWNERS
		if(!empty($owner_ids)){
			foreach($owner_ids as $owner_ids_fet){
				$owner_ids_fet = (int) $owner_ids_fet;
				//VehicleDriverOwner::create(['vehicle_driver_owners_vehicle_id' => $vehicle_inserted_id, 'vehicle_driver_owners_driver_id' => $owner_ids_fet]);
				Vehicle::find($vehicle_inserted_id)->owners()->attach($owner_ids_fet);
			}
		}
		// END OWNERS

		//BEGIN AUTHORIZED DRIVERS
		$authorized_index = Input::get('authorized_index');

		// IF AUTHORIZED DRIVERS EXIST, ASSOCIATE WITH DRIVERS.(CHECKING USING LICENSE)
		if($authorized_index!=""){
			$authorized_index_arr = explode(',', $authorized_index);

			foreach($authorized_index_arr as $authorized_index_id){
				$authorized_license_no = Input::get('authorized_license_no'.$authorized_index_id);
				$authorized_status = Driver::where('drivers_license_no', $authorized_license_no)->first();
				

				//IF DRIVER DOESN'T EXISTS, CREATE DRIVER
				if($authorized_status == NULL){

					$authorized_info['drivers_fname']          = Input::get('authorized_fname'.$authorized_index_id);
					$authorized_info['drivers_mname']          = Input::get('authorized_mname'.$authorized_index_id);
					$authorized_info['drivers_lname']          = Input::get('authorized_lname'.$authorized_index_id);
					$authorized_info['drivers_nin']            = Input::get('authorized_nin'.$authorized_index_id);
					$authorized_info['drivers_license_no']     = Input::get('authorized_license_no'.$authorized_index_id);
					$authorized_info['drivers_street']         = Input::get('authorized_street'.$authorized_index_id);
					$authorized_info['drivers_city']           = Input::get('authorized_city'.$authorized_index_id);
					$authorized_info['drivers_po_box']         = Input::get('authorized_po_box'.$authorized_index_id);
					$authorized_info['drivers_country']        = Input::get('authorized_country'.$authorized_index_id);
					$authorized_info['drivers_cell1']          = Input::get('authorized_cell1'.$authorized_index_id);
					$authorized_info['drivers_cell2']          = Input::get('authorized_cell2'.$authorized_index_id);
					$authorized_info['drivers_email']          = Input::get('authorized_email'.$authorized_index_id);
					$authorized_info['drivers_driving_status'] = Input::get('authorized_driving_status'.$authorized_index_id);

					$insert_authorized_into_driver_table = Driver::create($authorized_info);
					$authorized_ids[] = $insert_authorized_into_driver_table->id;
					
				}
				// IF DRIVER EXISTS, GET HIS ID
				else {
					$authorized_ids[] = Driver::where('drivers_license_no', $authorized_license_no)->first()->id;
				}
			}

			// LINK VEHICLE WITH AUTHORIZED DRIVERS
			foreach($authorized_ids as $authorized_ids_fet){
				$authorized_ids_fet = (int) $authorized_ids_fet;
				//VehicleDriverAuthorized::create(['vehicle_driver_authorized_vehicle_id' => $vehicle_inserted_id, 'vehicle_driver_authorized_driver_id' => $authorized_ids_fet]);
				Vehicle::find($vehicle_inserted_id)->authorizedDrivers()->attach($authorized_ids_fet);
			}
		}
		// END AUTHORIZED DRIVERS



		// BEGIN INSURANCE
		if(Input::get('insurances_company')!="")
		{
			$insurance_arr = new Insurance(Input::only('insurances_company', 'insurances_policy_no', 'insurances_exp_date', 'insurances_agent_fname', 'insurances_agent_lname', 'insurances_agent_cell', 'insurances_agent_city', 'insurances_agent_email'));
			//$insurance_arr['insurances_vehicle_id'] = $vehicle_inserted_id;
			//Insurance::create($insurance_arr);
			Vehicle::find($vehicle_inserted_id)->insurance()->save($insurance_arr);
			
		}
		// END INSURANCE


		// BEGIN LIEN HOLDER
		if(Input::get('lien_index'))
		{
			$lien_arr = new Lien(Input::only('liens_collateral_id', 'liens_collateral_value', 'liens_bank_name', 'liens_bank_branch', 'liens_bank_street', 'liens_bank_city'));
			//$lien_arr['liens_vehicle_id'] = $vehicle_inserted_id;
			//Lien::create($lien_arr);
			Vehicle::find($vehicle_inserted_id)->lien()->save($lien_arr);
		}
		// END LIEN HOLDER
		

		// BEGIN FILES
		$files_col = Input::file();
		$files_count =  count(array_filter($files_col['files']));

		// IF FILES EXISTS
		if($files_count){
			foreach($files_col['files'] as $files){
				$filename_ar   = explode('.', $files->getClientOriginalName());
				$document_ext  = end($filename_ar);
				$path          = public_path().'/vehicledata/documents';
				
				// GENERATE RANDOM FILE NAME AND ADD EXTENSION
				$randName      = md5(rand() * time());
				$document_name = $randName . '.' . $document_ext;
				
				// MOVE FILE AND ENTRY INTO DATABASE
				if($files->move($path, $document_name)) {
					//Document::create(['documents_vehicle_id' => $vehicle_inserted_id, 'documents_name' => $document_name]);
					Vehicle::find($vehicle_inserted_id)->documents()->save(new Document(['documents_name' => $document_name]));
				}
			}
		}
		// END FILES
		 
		// BEGIN REGISTRATION
		if(isset($vehicle_inserted_id) && $vehicle_inserted_id !=""){
			$registrations_vehicle_id       = $vehicle_inserted_id;
			$registrations_no               = Input::get('registrations_no');
			$registrations_licence_plate_no = Input::get('registrations_licence_plate_no');

			if($registrations_no !="" && $registrations_licence_plate_no != "" && $registrations_vehicle_id != ""){
				$vehicles_use_type = Input::get('vehicles_use_type');
				$vehicles_class    = Input::get('vehicles_class');

				if($vehicles_use_type !="" && $vehicles_class !=""){

					$vehicles_use_type_table_name = VehicleUseType::find($vehicles_use_type)->vehicle_use_types_table_name;

					//REGISTRATION FEES
					$vehicles_class_col_name = $vehicles_use_type_table_name.'_total';
					$registrations_fees = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;

					// INCREMENT REGISTRATION SEQUENCE
					$vehicles_sequence_col_name = $vehicles_use_type_table_name.'_sequence';
					$currentSequence = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_sequence_col_name;
					$newSequence = $currentSequence+1;

					DB::table($vehicles_use_type_table_name)->where('id', $vehicles_class)->update([$vehicles_sequence_col_name => $newSequence]);
					
					$registration_ar = compact('registrations_vehicle_id', 'registrations_no', 'registrations_licence_plate_no', 'registrations_fees');
					//Registration::create($registration_ar);
					Vehicle::find($vehicle_inserted_id)->registration()->save(new Registration($registration_ar));

					// TAKE LOGS
					$newVehiclesStatus = Input::get('vehicles_status');
					$newVehicleColor = Input::get('vehicles_color');
					$newVehicleUseType = Input::get('vehicles_use_type');
					$newVehiclesRegistrationNo = Input::get('registrations_no');
					$vehicles_odometer = Input::get('vehicles_odometer');
					
					LogVehicleStatus::create(['log_vehicle_status_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_status_vehicle_status_id' => $newVehiclesStatus]);					
					
					LogVehicleColor::create(['log_vehicle_color_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_color_color_id' => $newVehicleColor]);
					
					LogVehicleUseType::create(['log_vehicle_use_type_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_use_type_use_type' => $newVehicleUseType, 'log_vehicle_use_type_registration_no' => $newVehiclesRegistrationNo]);
					
					LogVehicleOdometer::create(['log_vehicle_odometer_vehicle_id' => $registrations_vehicle_id, 'log_vehicle_odometer_old_odometer' => $vehicles_odometer, 'log_vehicle_odometer_status' => 1]);

					return Redirect::route('vehicle.print', [$registrations_vehicle_id]);
				}
			}
		}else{
			echo "Nothing is saved because fields are not filled";
			die();
		} 
		// END REGISTRATION
	}// END CHANGE OWNER UPDATE

	public function vehicleRevisions($id){
		if(Vehicle::find($id)){
			$vehicle = Vehicle::find($id);
			$vehicleStatus = true;
		}else {
			$vehicle = Vehicle::withTrashed()->find($id);
			$vehicleStatus = false;
		}
		
		$vehicle['vehicles_class_name'] = Vehicle::vehicleClassName($id);
		$registration = $vehicle->registrationTrashed;
		$owners = $vehicle->owners;
		$authorizedDr = $vehicle->authorizedDrivers;
		$documents = $vehicle->documents;
		$insurance = $vehicle->insuranceTrashed;
		$lien = $vehicle->lienTrashed;
		$deletedOnwers = $vehicle->deletedOwners;
		$deletedAuthorizedDrivers = $vehicle->deletedAuthorizedDrivers;

		
		$data = compact('registration', 'vehicle', 'vehicleStatus', 'owners', 'deletedOnwers', 'authorizedDr', 'deletedAuthorizedDrivers', 'documents', 'insurance', 'lien');
		return View::make('vehicle.revisions', $data);
	}

	public function vehicleHistory($id){
		$oldVehicleIds = Vehicle::getVehicleHistory($id);
		foreach($oldVehicleIds as $oldVehicleId){
			$oldVehicleData[] = Vehicle::withTrashed()->find($oldVehicleId);
		}

		$currentVehicle = end($oldVehicleIds);


		$data = compact('oldVehicleData', 'currentVehicle');
		//echo "<pre>";
		//print_r($oldVehicleData);

		return View::make('vehicle.history', $data);
		
	}

	

	
}