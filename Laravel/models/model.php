<?php //models/Vehicle.php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Vehicle extends Eloquent {

	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'vehicles';
	

	protected $fillable = ['vehicles_vin', 'vehicles_year', 'vehicles_make_id', 'vehicles_name_trim', 'vehicles_model_id', 'vehicles_body', 'vehicles_weight_kg', 'vehicles_use_type', 'vehicles_class', 'vehicles_color', 'vehicles_status', 'vehicles_odometer', 'vehicles_transfer'];

	// EACH VEHICLE MODEL BELONGS TO MODEL TABLE
	public function model(){
		return $this->belongsTo('Model', 'vehicles_model_id', 'id');
	}

	// EACH VEHICLE USE TYPE BELONGS TO VEHICLE USE TYPE TABLE
	public function vehicleUseType(){
		return $this->belongsTo('VehicleUseType', 'vehicles_use_type', 'id');
	}

	// EACH VEHICLE COLOR BELONGS TO COLORS TABLE
	public function color(){
		return $this->belongsTo('Color', 'vehicles_color', 'id');
	}

	// EACH VEHICLE STATUS BELONGS TO VEHICLE STATUS TABLE
	public function vehicleStatus(){
		return $this->belongsTo('VehicleStatus', 'vehicles_status', 'id');
	}

	// EACH VEHICLE CAN HAVE ONE INSURANCE
	public function insurance(){
		return $this->hasOne('Insurance', 'insurances_vehicle_id', 'id');
	}

	// DELETED VEHICLE INSURANCE
	public function insuranceTrashed(){
		return $this->hasOne('Insurance', 'insurances_vehicle_id', 'id')->withTrashed();
	}

	// EACH VEHICLE CAN HAVE ONE LIEN
	public function lien(){
		return $this->hasOne('Lien', 'liens_vehicle_id', 'id');
	}

	// DELETED VEHICLE LIEN
	public function lienTrashed(){
		return $this->hasOne('Lien', 'liens_vehicle_id', 'id')->withTrashed(0);
	}

	// EACH VEHICLE CAN HAVE MANY DOCUMENTS
	public function documents(){
		return $this->hasMany('Document', 'documents_vehicle_id', 'id');
	}

	// EACH VEHICLE BELONGS TO MANY OWNERS
	public function owners(){
		return $this->belongsToMany('Driver', 'vehicle_driver_owners', 'vehicle_driver_owners_vehicle_id', 'vehicle_driver_owners_driver_id')->whereNull('vehicle_driver_owners.deleted_at')->withTimestamps();
	}

	// DELETED OWNERS OF VEHICLE
	public function deletedOwners(){
		return $this->belongsToMany('Driver', 'vehicle_driver_owners', 'vehicle_driver_owners_vehicle_id', 'vehicle_driver_owners_driver_id')->whereNotNull('vehicle_driver_owners.deleted_at')->withTimestamps();
	}

	/*
	public function test(){
		return $this->belongsToMany('Driver', 'vehicle_driver_owners', 'vehicle_driver_owners_vehicle_id', 'vehicle_driver_owners_driver_id')->whereNull('vehicle_driver_owners.deleted_at')->withTimestamps()->withTrashed();
	}
	*/

	// EACH VEHICLE BELONGS TO MANY AUTHORIZED DRIVERS
	public function authorizedDrivers(){
		return $this->belongsToMany('Driver', 'vehicle_driver_authorized', 'vehicle_driver_authorized_vehicle_id', 'vehicle_driver_authorized_driver_id')->whereNull('vehicle_driver_authorized.deleted_at')->withTimestamps();
	}

	// DELETED AUTHORIZED DRIVERS
	public function deletedAuthorizedDrivers(){
		return $this->belongsToMany('Driver', 'vehicle_driver_authorized', 'vehicle_driver_authorized_vehicle_id', 'vehicle_driver_authorized_driver_id')->whereNotNull('vehicle_driver_authorized.deleted_at')->withTimestamps();
	}

	// EACH VEHICLE HAS A REGISTRATION DETAIL
	public function registration(){
		return $this->hasOne('Registration', 'registrations_vehicle_id', 'id');
	}

	// DELETED VEHICLE REGISTRATION DETAIL
	public function registrationTrashed(){
		return $this->hasOne('Registration', 'registrations_vehicle_id', 'id')->withTrashed();
	}

	// EACH VEHICLE CAN HAVE MANY VOILATIONS (ALL VOILATIONS - PENDING, PAID AND SUSPENDED)
	public function voilations(){
		return $this->hasMany('ViolateVehicle', 'vehicle_id', 'id');
	}

	// EACH VEHICLE CAN HAVE MANY PRE REGISTRATION VEHICLE VOILATIONS
	public static function preRegistrationVoilations($id){
		$vehicle = self::find($id);		
		$registrationDate = date("Y-m-d", strtotime($vehicle->registration->created_at->toDateTimeString()));
		return ViolateVehicle::where('vehicle_id', $id)->where('status', 2)->where('created_at', $registrationDate)->get();
	}

	// EACH VEHICLE CAN HAVE MANY PRE REGISTRATION DRIVER VOILATIONS
	public static function preRegistrationDriverVoilations($id){
		$vehicle = self::find($id);		
		$registrationDate = date("Y-m-d", strtotime($vehicle->registration->created_at->toDateTimeString()));
		return ViolateDriver::where('vehicle_id', $id)->where('status', 2)->orWhere('status', 1)->where('created_at', $registrationDate)->get();
	}



	// EACH VEHICLE CAN HAVE MANY PENDING VOILATIONS
	public function voilationsPaid(){
		return $this->hasMany('ViolateVehicle', 'vehicle_id', 'id')->where('status', 1);
	}

		
	// EACH VEHICLE CAN HAVE MANY PENDING VOILATIONS
	public function voilationsPending(){
		return $this->hasMany('ViolateVehicle', 'vehicle_id', 'id')->where('status', 2);
	}

	// EACH VEHICLE CAN HAVE MANY PENDING VOILATIONS
	public function voilationsSuspended(){
		return $this->hasMany('ViolateVehicle', 'vehicle_id', 'id')->where('status', 3);
	}	

	public function getOldVehicleStatus(){
		return $this->hasMany('LogVehicleStatus', 'log_vehicle_status_vehicle_id', 'id');
	}

	public function getOldColor(){
		return $this->hasMany('LogVehicleColor', 'log_vehicle_color_vehicle_id', 'id');
	}

	public function getOldUseType(){
		return $this->hasMany('LogVehicleUseType', 'log_vehicle_use_type_vehicle_id', 'id');
	}

	public function getOldOdometer(){
		return $this->hasMany('LogVehicleOdometer', 'log_vehicle_odometer_vehicle_id', 'id');
	}

	public function driverViolations(){
		return $this->hasMany('ViolateDriver', 'vehicle_id', 'id');
	}

	
	// RULES FOR VALIDATION
	public static $rules = [
					'vehicles_vin'       => 'required|unique:vehicles,vehicles_vin',
					'vehicles_year'      => 'required|integer|exists:models,model_year',
					'vehicles_make_id'   => 'required|exists:models,model_make_id',
					'vehicles_name_trim' => 'required',
					'vehicles_body'      => '',
					'vehicles_weight_kg' => 'required|numeric|exists:models,model_weight_kg',
					'vehicles_use_type'  => 'required|numeric|exists:vehicle_use_types,id',
					'vehicles_class'     => 'required|required|numeric',
					'vehicles_color'     => 'required|numeric|exists:colors,id',
					'vehicles_status'    => 'required|numeric|exists:vehicle_status,id',
					'vehicles_odometer'  => 'integer'
				];

	public static function checkVin($vehicles_vin){
		$vehicles_vin_status = Vehicle::where('vehicles_vin', $vehicles_vin)->get()->count();
		if($vehicles_vin_status > 0) return 1;
	}

	public static function checkLicense($registrations_licence_plate_no_status){
		$registrations_licence_plate_no_status = Registration::withTrashed()->where('registrations_licence_plate_no', $registrations_licence_plate_no_status)->get()->count();
			
		if($registrations_licence_plate_no_status > 0) return 1;
	}

	

	public static function vehicleData($id){
		$vehicle = self::find($id);
		$vehicleData = new stdClass();

		$vehicleData->id = $id;
		$vehicleData->vehicles_vin = $vehicle->vehicles_vin;
		$vehicleData->vehicles_model_year = $vehicle->model->model_year;
		$vehicleData->vehicles_model_make_id = $vehicle->model->model_make_id;
		$vehicleData->vehicles_model_name = $vehicle->model->model_name;
		$vehicleData->vehicles_model_trim = $vehicle->model->model_trim;
		$vehicleData->vehicles_model_name_trim = $vehicleData->vehicles_model_name.", ".$vehicleData->vehicles_model_trim;
		$vehicleData->vehicles_model_body = $vehicle->model->model_body;
		$vehicleData->vehicles_model_weight_kg = $vehicle->model->model_weight_kg;
		$vehicleData->vehicles_status = $vehicle->vehicles_status;
		$vehicleData->vehicles_odometer = $vehicle->vehicles_odometer;
		$vehicleData->vehicles_color = $vehicle->vehicles_color;
		$vehicleData->vehicles_use_type = $vehicle->vehicles_use_type;
		$vehicleData->vehicles_class = $vehicle->vehicles_class;
		$vehicleData->vehicles_class_name = self::vehicleClassName($id);

	    return $vehicleData;
	}

	public static function vehicleClassName($id){
		$vehicle = self::withTrashed()->find($id);
		$vehicles_class = $vehicle->vehicles_class;
		$vehicles_use_type_table_name = $vehicle->vehicleUseType->vehicle_use_types_table_name;
		
		$vehicles_class_col_name = $vehicles_use_type_table_name.'_class';
		return $vehicles_class_name = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;
	}

	public static function vehicleRegistrationSequence($vehicles_use_type, $vehicles_class){
		$vehicles_use_type_table_name = VehicleUseType::find($vehicles_use_type)->vehicle_use_types_table_name;
		$vehicles_class_col_name = $vehicles_use_type_table_name.'_sequence';
		$sequence =  DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name + 1;
		return str_pad($sequence, 7, 0, STR_PAD_LEFT);
	}

	public static function vehicleStickerPrefix($id){
		$vehicle = self::withTrashed()->find($id);
		$vehicles_class = $vehicle->vehicles_class;
		$vehicles_use_type_table_name = $vehicle->vehicleUseType->vehicle_use_types_table_name;
		
		$vehicles_class_col_name = $vehicles_use_type_table_name.'_sticker_prefix';

		return $vehicles_class_name = DB::table($vehicles_use_type_table_name)->find($vehicles_class)->$vehicles_class_col_name;
	}

	public static function noOfPassengers($id){
		$vehicle = self::find($id);
		$vehicles_use_type_table_name = $vehicle->vehicleUseType->vehicle_use_types_table_name;
		return $noOfPassengers = ['-1' => 'Select No. Of Passengers'] + DB::table($vehicles_use_type_table_name)->lists($vehicles_use_type_table_name.'_no_of_passenger', 'id');
	}
	/**
	 * GENERATE REGISTRATION OF VEHICLE
	 * @param  INT $id VEHICLE'S ID
	 * @return STR     REGISTRATION NO
	 */
	public static function registrationNoUpdated($id){

		$vehicle = self::find($id);

		$vehicles_use_type   = $vehicle->vehicles_use_type;
		$vehicles_class      = $vehicle->vehicles_class;
		$vehicles_class_name = self::vehicleClassName($id);
		$year                = date("Y");
		$model_year          = $vehicle->model->model_year;
		$model_make_id       = strtoupper(substr($vehicle->model->model_make_id, 0, 4));
		//$class_sequence      = str_pad(self::withTrashed()->where('vehicles_use_type', $vehicles_use_type)->where('vehicles_class', $vehicles_class)->count()+1, 7, 0, STR_PAD_LEFT);

		$class_sequence = self::vehicleRegistrationSequence($vehicles_use_type, $vehicles_class);

		return $registrationNoUpdated = $vehicles_class_name."-".$year."-".$model_year."-".$model_make_id."-".$class_sequence;


	}

	public static function getPreviousVehicleId($id){
		return self::withTrashed()->where('vehicles_transfer', $id)->first()->id;
	}

	public static function getVehicleHistory($id){
		// STORE ORIGINAL ID IN A DIFFERENT VARIABLE(NEED IT LATER)
		$originalId = $id;
		$oldVehicleIds[] = $id;
		$oldVehicle = self::withTrashed()->where('vehicles_transfer', $id)->first();

		// IF SOME VEHICLE HAS BEEN TRASFERRED TO THIS VEHICLE 
		if($oldVehicle){
			$id = $oldVehicle->id;
			$oldVehicleIds[] = $id;

			$i = 1;
			do {
				${"oldVehicle" . $i} = self::withTrashed()->where('vehicles_transfer', $id)->first();
				if(${"oldVehicle" . $i}){
					$id = ${"oldVehicle" . $i}->id;
					$oldVehicleIds[] = $id;
					$i++;
					$oldVehicleStatus = true;
				}else $oldVehicleStatus = false;
			}while($oldVehicleStatus == true);
			
			$oldVehicleIds = array_reverse($oldVehicleIds);

			$j = 1;
			do {
				${"newVehicle" . $j} = self::withTrashed()->find($originalId)->vehicles_transfer;
				if(${"newVehicle" . $j}){
					$originalId = ${"newVehicle" . $j};
					$oldVehicleIds[] = ${"newVehicle" . $j};
					$j++;
					$newVehicleStatus = true;
				}else $newVehicleStatus = false;
			}while($newVehicleStatus == true);

			if($oldVehicleStatus == false && $newVehicleStatus == false)
				return $oldVehicleIds;
		}
		// NO VEHICLE HAS BEEN TRANSFERRED TO THIS VEHICLE, CHECK IF THIS VEHICLE WAS TRANSFERRED FURTHER 
		else {
			$j = 1;
			do {
				${"newVehicle" . $j} = self::withTrashed()->find($originalId)->vehicles_transfer;
				if(${"newVehicle" . $j}){
					$originalId = ${"newVehicle" . $j};
					$oldVehicleIds[] = ${"newVehicle" . $j};
					$j++;
					$newVehicleStatus = true;
				}else $newVehicleStatus = false;
			}while($newVehicleStatus == true);

			if($newVehicleStatus == false)
				return $oldVehicleIds;
		}
	}

	/**
	 * GET ASSOCIATED PENDING FINES MESSAGES OF VEHICLE
	 * @param  int $id ID OF VEHICLE
	 * @return html     FINES MESSAGES
	 */
	public static function getVehiclePendingFinesMessage($id){
		$vehicle = Vehicle::find($id);
		$voilationsCount = $vehicle->voilationsPending->count();
		$msg = "";
		
		// PENDING VEHICLE VOILATIONS EXISTS
		if($voilationsCount > 0){
			$vehicle_voilations_unique_id_ar = $vehicle->voilationsPending->lists('vehicle_fine_unique_id');
			$vehicle_ids = implode(", ", $vehicle_voilations_unique_id_ar);
			

			$msg .= "<div class='row'><div class='col-md-12'>This Vehicle has $voilationsCount pending fines ($vehicle_ids)</div></div>";


			// BEGIN VEHICLE OWNERS FINE				
			$vehicleOwners = $vehicle->owners;

			foreach($vehicleOwners as $vehicleOwner){
				if($vehicleOwner->voilationsPending->count() > 0){
					$vehicleOwnerFinesIds[$vehicleOwner->id] = $vehicleOwner->voilationsPending->lists('driver_fine_unique_id');
				}
			}
			
			// IF VEHICLE OWNER FINES EXISTS
			if(isset($vehicleOwnerFinesIds) && count($vehicleOwnerFinesIds) > 0){
				foreach($vehicleOwnerFinesIds as $ownerId => $vehicleOwnerFinesId){
					$owner = Driver::find($ownerId);
					$ownerName = $owner->drivers_fname." ".$owner->drivers_mname." ".$owner->drivers_lname ;
					// FINES ID IS IN ARRAY, SO IMPLODE IT
					$finesIdStr = implode(',', $vehicleOwnerFinesId);
					$msg .= "<div class='row'><div class='col-md-12'>Owner ($ownerName) has ".count($vehicleOwnerFinesId)." pending fines ($finesIdStr)</div></div>";
				}
			}
			
			// END VEHICLE OWNERS FINE
			
			
			// BEGIN VEHICLE AUTHORIZED DRIVERS FINE				
			$vehicleAuthorized = $vehicle->authorizedDrivers;

			foreach($vehicleAuthorized as $vehicleAuthorized){
				if($vehicleAuthorized->voilationsPending->count() > 0){
					$vehicleAuthorizedFinesIds[$vehicleAuthorized->id] = $vehicleAuthorized->voilationsPending->lists('driver_fine_unique_id');
				}
			}
				
			if(isset($vehicleAuthorizedFinesIds) && count($vehicleAuthorizedFinesIds) > 0){
				foreach($vehicleAuthorizedFinesIds as $authorizedId => $vehicleAuthorizedFinesId){
					$authorized = Driver::find($authorizedId);
					$authorizedName = $authorized->drivers_fname." ".$authorized->drivers_mname." ".$authorized->drivers_lname ;
					// FINES ID IS IN ARRAY, SO IMPLODE IT
					$finesIdStrAuthorized = implode(',', $vehicleAuthorizedFinesId);
					$msg .= "<div class='row'><div class='col-md-12'>Authorized Driver ($authorizedName) has ".count($vehicleAuthorizedFinesId)." pending fines ($finesIdStrAuthorized)</div></div>";
				}
			}
			// END VEHICLE AUTHORIZED DRIVER FINE

			if(!empty($msg)) return $msg;
		}
		// NO PENDING VEHICLE VOILATIONS, CHECK OWNERS VOILATIONS
		else{


			// BEGIN VEHICLE OWNERS FINE				
			$vehicleOwners = $vehicle->owners;

			foreach($vehicleOwners as $vehicleOwner){
				if($vehicleOwner->voilationsPending->count() > 0){
					$vehicleOwnerFinesIds[$vehicleOwner->id] = $vehicleOwner->voilationsPending->lists('driver_fine_unique_id');
				}
			}
			
			// IF VEHICLE OWNER FINES EXISTS
			if(isset($vehicleOwnerFinesIds) && count($vehicleOwnerFinesIds) > 0){
				foreach($vehicleOwnerFinesIds as $ownerId => $vehicleOwnerFinesId){
					$owner = Driver::find($ownerId);
					$ownerName = $owner->drivers_fname." ".$owner->drivers_mname." ".$owner->drivers_lname ;
					// FINES ID IS IN ARRAY, SO IMPLODE IT
					$finesIdStr = implode(',', $vehicleOwnerFinesId);
					$msg .= "<div class='row'><div class='col-md-12'>Owner ($ownerName) has ".count($vehicleOwnerFinesId)." pending fines ($finesIdStr)</div></div>";
				}
			}
			
			// END VEHICLE OWNERS FINE
			
			
			// BEGIN VEHICLE AUTHORIZED DRIVERS FINE				
			$vehicleAuthorized = $vehicle->authorizedDrivers;

			foreach($vehicleAuthorized as $vehicleAuthorized){
				if($vehicleAuthorized->voilationsPending->count() > 0){
					$vehicleAuthorizedFinesIds[$vehicleAuthorized->id] = $vehicleAuthorized->voilationsPending->lists('driver_fine_unique_id');
				}
			}
				
			if(isset($vehicleAuthorizedFinesIds) && count($vehicleAuthorizedFinesIds) > 0){
				foreach($vehicleAuthorizedFinesIds as $authorizedId => $vehicleAuthorizedFinesId){
					$authorized = Driver::find($authorizedId);
					$authorizedName = $authorized->drivers_fname." ".$authorized->drivers_mname." ".$authorized->drivers_lname ;
					// FINES ID IS IN ARRAY, SO IMPLODE IT
					$finesIdStrAuthorized = implode(',', $vehicleAuthorizedFinesId);
					$msg .= "<div class='row'><div class='col-md-12'>Authorized Driver ($authorizedName) has ".count($vehicleAuthorizedFinesId)." pending fines ($finesIdStrAuthorized)</div></div>";
				}
			}
			// END VEHICLE AUTHORIZED DRIVER FINE

			if(!empty($msg)) return $msg;
			
		};
	}
}