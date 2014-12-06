angular.module('starter.controllers', [])

.controller('LoginCtrl',function($rootScope,$scope,$sanitize,Auth,$location,$ionicModal,$timeout,storageService,$state){

  $scope.ifnotforget = true;

  $scope.datenow = new Date();

  $scope.$on('ROUTE_CHANGED',function(event,obj){
   data = Auth.checkuser();
   if(data !== null){
    
        checktime();      
      // $location.path('/app/dashboard');
       $rootScope.loginpassed = true;

   }else{
      $location.path('/login');
      $rootScope.loginpassed = false;
   }

  }); 
  
   
  $scope.taskstatus = Auth.checkuser();

  if($scope.taskstatus !== null){    
     checktime();
     $location.path('/app/dashboard');
     //$state.reload();
  }


  function checktime(){

     var time = new Date(parseInt(storageService.get('activity')));
     //var parse = JSON.parse(time);
     var time2 = $scope.datenow;
     //console.log(time2.getTime - parse.getTime);
   
        difference =  time2.getTime() - time.getTime();
        var daysDifference = Math.floor(difference/1000/60/60/24);
        difference -= daysDifference*1000*60*60*24;

        var hoursDifference = Math.floor(difference/1000/60/60);
        //difference -= hoursDifference*1000*60*60;
        //var minutesDifference = Math.floor(difference/1000/60);
        //difference -= minutesDifference*1000*60;
        console.log(hoursDifference); 
      
        if(hoursDifference  > 4){
          $location.path('/login');
          $rootScope.loginpassed = false;
        }
}

  
  //check user login status . if he has logined once switch view
  var login_status = storageService.get('loginedonce');  
  if(login_status){
    $scope.changelogintype = true;
  }  
  
  
  $scope.credentials = {
    email:'',
    password:'' 
  };

  //login user for first time 
  $scope.loginuser = function(){

    //console.log($scope.credentials);
    Auth.login($scope.credentials).then(function(response){

      response_code = response.data.code;
      
      if(response_code === '200'){
        $scope.errormessage = false; 
        //user found move to setting pin
       $scope.login();
       $scope.usernames = response.data.data;
       //console.log($scope.usernames.address);
      }else
        {
            // if user does not found
         $scope.errormessage = response.data.status;
      }
    })

  }

  $scope.loginData = {
     pin:'',
     badgeid:''
  }



  $scope.user = {};
  //setting pin
  $scope.setpin = function(){
  //console.log($scope.usernames);
   
  var pin = $sanitize($scope.user.pin);
  var isnum = /^\d+$/.test(pin);
   if(!isnum){
    $scope.errormessage = "Enter number only";
    return;
    }else
    $scope.errormessage = false;
    var pin_length=  pin.length;  
    if(pin_length === 4){
       pin_data =  "pin="+$sanitize($scope.user.pin)+"&email="+$sanitize($scope.usernames.email);
       //set user pin here and get response
       Auth.SetPin(pin_data).then(function(response){
       // console.log(response.data);
        response_code = response.data.code;
        if(response_code === '200'){
          //sessionStorage.user = $scope.usernames;
          storageService.save('loginedonce','yes');
          storageService.save('user',$scope.usernames);
       
          $scope.closeLogin();
        }
         else
        $scope.errormessage = response.data.status;
       });
        
     }else if(pin_length > 4){
        $scope.errormessage = "Pin should have 4 digits";
   }

  }


  //login user if he has logined once. login with pin and badge id
  $scope.secondlogin = function(){
    
    var user_pin = $sanitize($scope.loginData.pin);
   
    var isnum = /^\d+$/.test(user_pin);
     if(!isnum){
      $scope.errormessage = "Enter number only";
      return;
      }else
      $scope.errormessage =false;
      //console.log(user_login_data);
      user_login_data = "pin="+$scope.loginData.pin+"&badgeid="+$scope.loginData.badgeid;
      Auth.loginuser(user_login_data).then(function(response){
      //  console.log(response);
        response_code  = response.data.code;
        if(response_code === '200'){
         
          storageService.save('user',response.data.data);        
          $scope.closeLogin();
        }
        else
         {          
          $scope.errormessage = response.data.status;
         }
      });

  }

  //forget pin functionality

  $scope.forgetpin = function(){

    $scope.showback = true;
    $scope.ifnotforget= false;
    $scope.changelogintype = false;
    $scope.mesageforget = "Enter Email and password to set new Pin";

  }

  $scope.backtologin = function(){
    $scope.showback = false;
    $scope.ifnotforget= true;
    $scope.changelogintype = true;
    $scope.mesageforget = false;

  }

 // Create the login modal that we will use later
  $ionicModal.fromTemplateUrl('templates/login.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  });
  
 //close login
 $scope.closeLoginOnce =function(){

  $scope.modal.hide();
 } 

  // Triggered in the login modal to close it
  $scope.closeLogin = function() {
    
    $scope.modal.hide();
    $location.path('/app/dashboard');
  };

  // Open the login modal
  $scope.login = function() {
    $scope.modal.show();
  };

})
//controller for searching fines
.controller('SearchFineCtrl',function($scope,FineService,Auth,$rootScope,$sanitize,storageService){
   //check user logined or not
   $scope.$on('ROUTE_CHANGED',function(event,obj){
    data = Auth.checkuser();
   if(data !== null){
       //$location.path('/app/dashboard');
       $rootScope.loginpassed = true;
   }else{
      $location.path('/login');
      $rootScope.loginpassed = false;
   }
  });

    storageService.save('activity',+new Date);


   $scope.fines = {
     id:''
   }; 

   $scope.finestype = [{'name':'vehicle'},{'name':'driver'}];

    //fine type entered by user
   $scope.item = $scope.finestype[0];
   //update type
   $scope.updatetype = function(item){
    $scope.item = item;
   }

   //on search button enter
   $scope.searchfine = function(){
    $scope.finesresult = [];
    $scope.errormessage = [];

    $type = $scope.item.name;
    $fine_id = $scope.fines.id;
    $data = "type="+$type+"&fineid="+$fine_id;
    FineService.serachfine($data).then(function(response){
      console.log(response);
      response_data = response.data;
      response_code = response_data.code;
      if(response_code == '200'){

        $scope.finesresult = response_data.data;
        storageService.save('activity',+new Date);

      }else
      {
        $scope.errormessage = response_data.status;
      }
    })

   }
})
//controller for dashboard

.controller('DashCtrl',function($scope,$rootScope, Auth, SearchService,storageService,$ionicLoading,$location){

  $scope.message = ''; 
  //check routes
  $scope.$on('ROUTE_CHANGED',function(event,obj){
    data = Auth.checkuser();
   if(data !== null){
       //$location.path('/app/dashboard');
       $rootScope.loginpassed = true;

   }else{
      $location.path('/login');
      $rootScope.loginpassed = false;
   }
  });

  storageService.save('activity',+new Date);

  $scope.go = function(path){
   $location.path(path);
  }
  
 //get messages

 SearchService.getmessages().then(function(response){  
  $scope.messages =  response.data.data;
 })

 $scope.messagemain= function(typedmessage){

    $ionicLoading.show({
      content: 'Loading',
      animation: 'fade-in',
      showBackdrop: true,
      maxWidth: 200,
      showDelay: 0
    });

    var logineduser  = storageService.get('user');
    var pasedloginedUser = JSON.parse(logineduser); 
    $query_string = "message="+typedmessage+"&user_id="+pasedloginedUser.id;
    SearchService.mainalert($query_string).then(function(response){
     response_data = response.data;
     response_code = response_data.code;
     console.log(response_data);
     if(response_code == '200'){    
      $scope.messages =  response.data.data;         
      $ionicLoading.hide();
      $scope.typedmessage = '';  
      $scope.showsuccess = true;
     }   
  
    });

 };

})

//messages controller
.controller('MessagesCtrl' ,function($scope,$rootScope,SearchService,Auth,$stateParams,storageService,$ionicScrollDelegate,$location){

   //check routes
   $scope.$on('ROUTE_CHANGED',function(event,obj){
    data = Auth.checkuser();
   if(data !== null){
       //$location.path('/app/dashboard');
       $rootScope.loginpassed = true;

   }else{
      $location.path('/login');
      $rootScope.loginpassed = false;
   }
  });

  $scope.replymessagetext = {
   text:''
   };

   storageService.save('activity',+new Date);
 //get messages

 SearchService.getmessages().then(function(response){
  console.log(response.data);
  $scope.messages =  response.data.data;
 })
  
 //save message id 
 $messagesid = $stateParams.messageId;

 $scope.params  =  $messagesid;

 $scope.messagestrail  = function(){

     //$data = storageService.get('messagestrail');
     //parsed_datat = JSON.parse($data);
     //$scope.dataforparenttrail = parsed_datat;
     SearchService.getmessagestrail($messagesid).then(function(response){    

      $scope.messagestrail =  response.data.data;
     //  console.log($scope.messagestrail);
     //  $ionicScrollDelegate.scrollBottom(true);
     })

     }
  $scope.messagestrail();

 $messagesid =  $stateParams.messageId;

  $scope.replymessage = function(){
  
    replymessagetext = $scope.replymessagetext.text;
    $message_id = $messagesid;
    var logineduser  = storageService.get('user');
    var pasedloginedUser = JSON.parse(logineduser); 
  

    $query_string = "message="+replymessagetext+"&id="+$message_id+"&user_id="+pasedloginedUser.id;

    SearchService.replymessage($query_string).then(function(response){
     response_data = response.data;
     response_code = response_data.code;
     console.log(response_code);
     if(response_code === '200'){
       console.log(response_data.data);
       $scope.messagestrail =  response_data.data;      
        $ionicScrollDelegate.scrollBottom(true);
        $scope.replymessagetext.text = '';
     }
     
      

    })

  }


})

//controller for vehicles search and other action related to vehicle. 
.controller('VehicleCtrl',function($scope,$sanitize,$rootScope ,SearchService,Auth,$ionicScrollDelegate,storageService){

   $scope.$on('ROUTE_CHANGED',function(event,obj){
    data = Auth.checkuser();
   if(data !== null){
       //$location.path('/app/dashboard');
       $rootScope.loginpassed = true;

   }else{
      $location.path('/login');
      $rootScope.loginpassed = false;
   }
  });

 $scope.showvehicleSearch = true;
 
 $scope.hidetemp  =  true;
  //user activity
 storageService.save('activity',+new Date);

 $scope.vehicle = {
  reg_number:'',
  lic_number:'',
  nin_number:'',
  sticker_number:'',
  driver_lic_number:''

 }

 
  //cases for clearing other inputs except current one
 $scope.switchstates = function(input){
 
   switch(input){
     case '1':  
      $scope.vehicle = {
            reg_number:$scope.vehicle.reg_number,
            lic_number:'',          
            sticker_number:'',
            driver_lic_number:''
           }
           return data = 
                "reg_number="+$sanitize($scope.vehicle.reg_number)+
                 "&case=1";
         
       break;
      case '2':      
      $scope.vehicle = {
            reg_number:'',
            lic_number:$scope.vehicle.lic_number,           
            sticker_number:'',
            driver_lic_number:''

           }
        return data = 
                "lic_number="+$sanitize($scope.vehicle.lic_number)+
                 "&case=2";    
      break;
     
      case '3':
       $scope.vehicle = {
            reg_number:'',
            lic_number:'',          
            sticker_number:$scope.vehicle.sticker_number,
            driver_lic_number:''

           }
            return data = 
                "sticker_number="+$sanitize($scope.vehicle.sticker_number)+
                 "&case=3";  

      break;
      case '4':
     
       $scope.vehicle = {
            reg_number:'',
            lic_number:'',         
            sticker_number:'',
            driver_lic_number:$scope.vehicle.driver_lic_number

           }
           return data = 
                "driver_lic_number="+$sanitize($scope.vehicle.driver_lic_number)+
                 "&case=4";  
      break;
      default:
      $scope.vehicle = {
          reg_number:'',
          lic_number:'',         
          sticker_number:'',
          driver_lic_number:''

         }
      break;

   }

 }
  //return case

 $scope.returncase = function(input){

  if(input.reg_number){    
    $case = '1';
   
   }else if (input.lic_number){
   
    $case = '2';
   }else if(input.sticker_number){
   
    $case = '3';
  
   }else if(input.driver_lic_number){
  
   $case = '4';
  }
  return $case;

 } 

 $scope.watchfield = function(type){  
    $scope.vehicles = false;  
    $scope.switchstates(type);  
 
 }


 //search vehicle
 $scope.searchevehicle = function(){
 
  var caseall  = $scope.returncase($scope.vehicle);
 
  data_to_send = $scope.switchstates(caseall);
  
  SearchService.search(data_to_send).then(function(response){
    
   //all vehicle data response for different searches
    response_data =  response.data;
    console.log(response_data);
    $scope.showvehicleSearch = false;
    console.log($scope.showvehicleSearch);
    response_code =  response_data.code;
    if(response_code !== '200'){
     $scope.result =  response_data.status;
     return;
    }
    $scope.result  =  false;
  
    $scope.hidetemp = false;

    $scope.vehicles =  response_data.data;
   
   

  })
 }

})

//controller for vehicle detail page
.controller('VehicleDetailCtrl',function($scope,$stateParams,SearchService,$location,$ionicPopup,storageService){

   id = $stateParams.vehicleId;
   $scope.param = id;

  storageService.remove('driverselected');
  //user activity
  storageService.save('activity',+new Date);

  SearchService.Detail(id).then(function(response){
  response_data =  response.data;
  response_code = response_data.code;
  if(response_code === '200'){

   
   $scope.vehicledetail =  response_data.data;
    console.log($scope.vehicledetail);
   $scope.alldrivers = response_data.data.drivers;
   $scope.drivers = [];
   $scope.item = response_data.data.drivers[0];
   $scope.selecteddriver  = $scope.item.id;
   angular.forEach(response_data.data.drivers,function(value,key){
    $scope.drivers.push(value);
   
   });
 
   $scope.alldrivers.unshift({'id':'v','name':'vehicle'});

   //$scope.driverforfine =$scope.alldrivers[0] ;
  
  }
  });
  SearchService.registerdetail(id).then(function(response){

    $scope.registeration = response.data.data;
  })

  $scope.openfirst = true; 

  $scope.item = $scope.drivers;
  //select operation
  $scope.update =  function(item){

   $scope.selecteddriver =  item.id;
  }

  var savedPopup;
  
  $scope.showpopup = function() {
      $ionicPopup.show({
        templateUrl:  'choose-driver-template.html',
        title: 'Select Driver or Vehicle',
        scope: $scope,
        buttons: [
          { text: 'Cancel', onTap: function(e) { return true; } },
           {
        text: '<b>Select</b>',
        type: 'button-positive ',
        onTap: function(e) {
          if (!$scope.driverforfine) {
              //don't allow the user to close unless he enters wifi password
              e.preventDefault();
             }else{
              var item = $scope.driverforfine;
              if(item.id == 'v'){
                type= "vehicle";
              }else
                 {
                  type = "driver";
                  storageService.save('driverselected','yes');
                 }
               path = "app/issuefine/"+type+"/"+item.id+"/"+id;
               
               console.log(path);
               
               storageService.save('drivers', $scope.alldrivers);
               $location.path(path);
             return $scope.driverforfine;
          }
           
        }
      },
         
        ]
      }).then(function(res) {
        console.log('Tapped!', res);
      }, function(err) {
        console.log('Err:', err);
      }, function(popup) {
        console.log("reached");
        // If you need to access the popup directly, do it in the notify method
        // This is also where you can programatically close the popup:
        // popup.close();
          console.log('The popup');
          console.log(popup);
        savedPopup = popup;
      });    
  }

  //update drivr or vehicle to be sent for fine

  $scope.updatedriver = function(updatedriver){
   $scope.driverforfine = updatedriver;
  
  }

})

.controller('AppCtrl', function($scope, $location ,storageService) {
 
  $scope.logout  = function(){   
    storageService.remove('user');
    $location.path('/login');
  }

  $scope.go = function(path){

    $location.path(path);
  }

})

//controller to add new driver
.controller('DriverCtrl',function($scope,DriverService,$stateParams,$sanitize,$location){
    //get all countries and select gambia default
    DriverService.country().then(function(response){
     //console.log(response.data);
     $scope.countries = response.data.data;     
     $scope.driver.country = "Gambia";
    });

    //user activity
   storageService.save('activity',+new Date);
    
    //get all driver status
   DriverService.status().then(function(response){
     //console.log(response.data);
     $scope.status = response.data.data;     
      $scope.driver.status = "Current";
    });
   //initialize driver detail scope
   $scope.driver = {};
   $scope.driver.vehicle_id = $stateParams.vehicleId;
   //register driver
   $scope.registerdriver = function(){
    //stringyfy json and send to server
    post_data  = JSON.stringify($scope.driver);
    DriverService.register(post_data).then(function(response){
      
      response_data = response.data;
      status = response_data.code;
      if(status == '200'){
         path = "app/vehicle/"+$stateParams.vehicleId; 
         $location.path(path);
      }else{
        $scope.errormessage = response_data.status;
      }
    });

   }
 

})
 //issue fine page . controll fine toggle and adding fines to vehicle or a driver
.controller('IssueFineCtrl',function($scope,$stateParams,FineService,storageService,$ionicPopup,$ionicScrollDelegate,SearchService,$location){

     RequestType = $stateParams.vehicleType;
     DriverId    = $stateParams.driverId;
     vehicleId   = $stateParams.vehicleId;

  //user activity
  storageService.save('activity',+new Date);

  $scope.driverid =  DriverId;
   
  $scope.finesfromlist = [];
  
  //get drivers from storage service
  var data_drivers =  storageService.get('drivers');   
  parsed = JSON.parse(data_drivers);
  parsed.shift();
  //all drivers
  $scope.alldrivers = parsed;

 function test(RequestType){
        if(RequestType == 'vehicle'){
          alternative = "driver";
         }
       else
         {
           alternative = "vehicle";
         }
        return alternative;
 }
 //check type for toggle that where we are curently and where we need to go 
 $scope.alternative = test(RequestType);
 console.log($scope.alternative);

 $scope.selectedfines =  [];
  //scope for deleting fines from fine list
 $scope.data = {
    showDelete: true
  };
 
//get fines category lists as selected by user
 
 FineService.getfinetype("data="+RequestType).then(function(response){
  
   response_data = response.data;
   $scope.finelists = response_data.data;
 });
  
 //get fine list as selected

 $scope.getfinelist = function(str){

  $scope.selectedfine  =str;
  
  post_data =  "type="+RequestType+"&name="+str;
  FineService.getlist(post_data).then(function(response){   
    response_data =  response.data;

    $scope.finedscp = response_data.data;
    console.log($scope.finedscp);
    $scope.fine_name =  response_data.data[0];
     $scope.showpopup();
  })
  //add all selected fines
  }

  
  //show pop up for fines list  
  var savedPopup;
  
  $scope.showpopup = function() {
      $ionicPopup.show({
        templateUrl:  'choose-fine-template.html',
        title: 'Select Violation',
        scope: $scope,
        buttons: [
          { text: 'Cancel', onTap: function(e) { return true; } },
        
        {
        text: '<b>Select</b>',
        type: 'button-positive',
        onTap: function(e) {
          if (!$scope.finesfromlist) {
               //don't allow the user to close unless he enters wifi password
                e.preventDefault();
               } else{
                        fines = $scope.finesfromlist;
                        angular.forEach(fines,function(data,value){
                         
                           fine = data;
                           type = RequestType;
                           data = {'name':fine,'type':type};
                         
                          arr = $scope.selectedfines;
                          var id = arr.length + 1;
                          var found = arr.some(function (el) {
                            return el.name === fine;
                          });
                          if (!found) {  $scope.selectedfines.push(data); }
                          $scope.finesfromlist = [];
                        })
             return $scope.finesfromlist;
          }
           
        }
      },
         
        ]
      }).then(function(res) {
        console.log('Tapped!', res);
      }, function(err) {
        console.log('Err:', err);
      }, function(popup) {
        // If you need to access the popup directly, do it in the notify method
        // This is also where you can programatically close the popup:
        // popup.close();
          console.log('The popup');
          console.log(popup);
        savedPopup = popup;
      });    
  }

 //get all fines when user select it. push and remove accordingly
  $scope.finename = function(fine){
  
     if($scope.finesfromlist.indexOf(fine) == -1){
        $scope.finesfromlist.push(fine);
     } 
     else
     {
        $scope.finesfromlist.splice(fine,1);
     }

  }

  

   //update new driver 
   $scope.updatedriver = function(driver){
  
    $scope.driverid =  driver.id;
    storageService.save('driverselected','yes');
   }
   //fine delete

  $scope.onItemDelete = function(item){
    console.log($scope.selectedfines);
    $scope.selectedfines.splice(item,1);
  } 
   //pop up for driver
   var savedPopup;
  
  $scope.getPOpDriverSelect = function() {
      $ionicPopup.show({
        templateUrl:  'choose-driver-template.html',
        title: 'Select Driver',
        scope: $scope,
        buttons: [
          { text: 'Cancel', onTap: function(e) { return true; } },
           {
        text: '<b>Select</b>',
        type: 'button-positive button-small',
        onTap: function(e) {
          if (!$scope.driverid) {
               //don't allow the user to close unless he enters wifi password
                e.preventDefault();
               } 
               else{                       
             return $scope.driverid;
          }
           
        }
      },
         
        ]
      }).then(function(res) {
        console.log('Tapped!', res);
      }, function(err) {
        console.log('Err:', err);
      }, function(popup) {
        console.log("reached");
        // If you need to access the popup directly, do it in the notify method
        // This is also where you can programatically close the popup:
        // popup.close();
          console.log('The popup');
          console.log(popup);
        savedPopup = popup;
      });    
  }


 
 //check if driver is selected or not
  $scope.checkdriverSelectedorNot = function(){

    var data =  storageService.get('driverselected');
    if(!data){
    $scope.getPOpDriverSelect();
    }
  } 

   //we will toggle fine user here.
  $scope.togglefine = function(){

   
    RequestType = $scope.alternative;
    if(RequestType === 'driver'){

      $scope.checkdriverSelectedorNot();
    }

    FineService.getfinetype("data="+RequestType).then(function(response){
  
     response_data = response.data;
     //console.log(response_data);
     $scope.finelists = response_data.data;
     $scope.alternative = test(RequestType);
     $ionicScrollDelegate.scrollTop(true);
     console.log($scope.alternative);
 });
  
  }

 

 //confirm vilation and take user to print page

  $scope.ConfirmFine = function(){
   // console.log($scope.driverid);

    var fine_data =  {'vehicleId':vehicleId,'driverId':$scope.driverid,'fines':$scope.selectedfines};
    console.log(fine_data);

    //href="#/app/confirm/fine"
    storageService.save('finesdetail',fine_data);
    $location.path('/app/confirm/fine');
  }
 

})

.controller('ConfirmFineCtrl',function($scope,storageService,FineService,$window,$ionicLoading,geoLocationService,$location,$ionicModal,$ionicPopup,$http){

  $scope.date = new Date();
         
  var data =  storageService.get('finesdetail');
  var parsed = JSON.parse(data);

  //get logined user data
   var logineduser  = storageService.get('user');
   var pasedloginedUser = JSON.parse(logineduser); 
   $scope.finedby = pasedloginedUser;
   console.log($scope.finedby);
  
   $scope.dataforfine =  parsed;
   
  //console.log($scope.dataforfine);  
  $scope.refreshData = function() {
    geoLocationService.getLocation().then(function(position) {
      console.log(position);
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
        $scope.latitude = lat;
        $scope.longitude = lng;
      
      $http.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+
        lat+","+lng+"&sensor=true&callback=JSON_CALLBACK").then(function(response){       
         var locationDetails=response.data.results[0].formatted_address;
         console.log(locationDetails);
         $scope.currentlocation = locationDetails;
        })
     
    });
  };

  $scope.refreshData();  

   // Create the success modal that we will use later
  $ionicModal.fromTemplateUrl('templates/signature.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  });
  
 //close login
 $scope.closeSIgnatrOnce =function(){
    console.log($scope.imageData);
    $scope.signaturemodal.hide();
 }  

  $ionicModal.fromTemplateUrl('templates/signature.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.signaturemodal = modal;
    

  });

  $scope.clearOk = function(){

     var content = document.getElementById("canvas1");
     console.log(content)
     var ctx = content.getContext('2d');
     ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
          
  }

 
  // Open the login modal
  $scope.takesignature = function() {  
    $scope.signaturemodal.show();
  };

  
  // Create the success modal that we will use later
  $ionicModal.fromTemplateUrl('templates/success.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
    

  });
  
 //close login
 $scope.closeLoginOnce =function(){

  $scope.modal.hide();
  $scope.succesonIssue =true;
  $location.path('app/dashboard');
 }   
  // Open the login modal
  $scope.login = function() {
    $scope.modal.show();
  };
  
   

  //get signature image data here
  $scope.$on('image',function(event,obj){
    //console.log(obj);
    $scope.imageData =  obj;
    console.log($scope.imageData);
  });

  $scope.showPrompt = function() {
     var confirmPopup = $ionicPopup.prompt({
       title: 'Location Not Found?',
       template: 'Unable to find your Geo location .Turn your GPS on!!',
       inputType: 'text',
       inputPlaceholder: 'MIA...'
     });
     confirmPopup.then(function(res) {
         $scope.refreshData();        
     });
   };
  
  $scope.issueandPrintfine= function(){   

    var latitude =  $scope.latitude;
    if(latitude == null || latitude == false){    
      $scope.showPrompt();
      return;
      }else{
        console.log(latitude);
       }

    var data = {'fine':$scope.dataforfine,'latitude':$scope.latitude,'longitude':$scope.longitude,'finedby':pasedloginedUser,'signature':$scope.imageData};
    
    $ionicLoading.show({
        content: '<i class="icon ion-loading-c"></i><br>Loading Program',
        animation: 'fade-in',
        showBackdrop: true,
        maxWidth: 500,
        showDelay: 500
    });
  
 
    FineService.issuefine(data).then(function(response){
     console.log(response.data);
     response_data = response.data;
     response_code = response_data.code;
     if(response_code === '200'){
       $scope.responsedata = response.data.data;
       $ionicLoading.hide();
       $scope.login();
       //user activity
      storageService.save('activity',+new Date);
      // console.log($scope.responsedata);
     }
    });

  }


  //print file here

  $scope.printfile = function(){ 

     var content = document.getElementById("printdata");

    cordova.plugins.printer.isAvailable(
    function (isAvailable,installedAppIds) {
        if(isAvailable){
           //console.log(installedAppIds);  
           plugin.printer.print(content, { appId: 'com.zebra.android.zebrautilities' });  
        }
        else{
          alert('Service NOT available');
        }  
    }
   );
  }
})

 //signature 
.controller('SignatureCapCtrl', function($scope,$rootScope, $location,$ionicSlideBoxDelegate, $ionicSideMenuDelegate){
  
    $scope.clearVal = 0;
    $scope.saveVal  = 0;

    $scope.clear = function () {
        $scope.clearVal += 1; //On this value change directive clears the context
    }

    $scope.saveToImage = function () {       
        $scope.saveVal = 1; //On this value change directive saves the signature
    }
    
     $scope.ok = function(){
      console.log("reached");
     }
     $scope.$on('image',function(event , obj){
      console.log(obj); 
      $scope.imageData = obj;
     })

}) 

//temporary registration
.controller('RegisterFineCtrl', function($scope,$stateParams ,$rootScope,RegService,DriverService,$location,storageService) {

    $scope.register ={
       vehiclevin:'',
       drivernin:'',
    }
   
    $scope.driver = {};
    //initite temp registration values
    $scope.temporary = {}; 
    
    $scope.dosomeaction =function(){

 
     $scope.driver.vehiclevin=$scope.register.vehiclevin;
     $scope.driver.nin=  $scope.register.drivernin;

        //get all countries and select gambia default
    DriverService.country().then(function(response){
     //console.log(response.data);
     $scope.countries = response.data.data;     
     $scope.driver.country = "Gambia";
    });
    
    //get all driver status
   DriverService.status().then(function(response){
     //console.log(response.data);
     $scope.status = response.data.data;     
      $scope.driver.status = "Current";
    });
    }
 
    $scope.checknin = function(){    
     RegService.Check(JSON.stringify($scope.register)).then(function(response){
      console.log(response.data);
      response_data =  response.data;
      response_code = response_data.code;
      if(response_code === '400'){
         $scope.adddriver = true;
         $scope.dosomeaction();
        }else if(response_code == '200'){
          $scope.adddrivr = false;
          $scope.temporary.driver = response_data.data;
          $scope.temporary.vehiclevin = $scope.register.vehiclevin;
          //console.log($scope.temporary);
          storageService.save('temp',$scope.temporary);
          path =  "app/temp/"+response_data.data.driver_id;
          $location.path(path);
      }     
     })

     $scope.changevin = function(){
       $scope.adddriver = false;
     }
       
     $scope.registervehicle = function(){
      console.log($scope.driver);
      RegService.savedriver(JSON.stringify($scope.driver)).then(function(response){
        response_data = response.data;
        response_code = response_data.code;
        if(response_code === '200'){
        
          driver_data = response_data.data;
          $scope.temporary.driver = driver_data;
          $scope.temporary.vehiclevin = $scope.driver.vehiclevin;
          console.log($scope.temporary);
          storageService.save('temp',$scope.temporary);
          path =  "app/temp/"+response_data.data.driver_id;
          $location.path(path);
          //user activity
          storageService.save('activity',+new Date);
        }
      });

     }
    }
})


.controller('TempFineCtrl',function($scope,$stateParams,$rootScope,storageService,$ionicPopup,FineService,$ionicScrollDelegate,$location){
   
    RequestType = "vehicle";
    DriverId    = $stateParams.driverId;
    
   
  $scope.driverid =  DriverId;
   
  $scope.finesfromlist = [];
  
  //get drivers from storage service
  var data_drivers =  storageService.get('temp');   
  parsed = JSON.parse(data_drivers);  
  $scope.alldrivers = parsed.driver;


 function test(RequestType){
        if(RequestType == 'vehicle'){
          alternative = "driver";
         }
       else
         {
           alternative = "vehicle";
         }
        return alternative;
 }
 //check type for toggle that where we are curently and where we need to go 
 $scope.alternative = test(RequestType);
 console.log($scope.alternative);

 $scope.selectedfines =  [];
  //scope for deleting fines from fine list
 $scope.data = {
    showDelete: true
  };
 
//get fines category lists as selected by user
 
 FineService.getfinetype("data="+RequestType).then(function(response){
  
   response_data = response.data;
   $scope.finelists = response_data.data;
 });
  
 //get fine list as selected

 $scope.getfinelist = function(str){

  $scope.selectedfine  = str;
  
  post_data =  "type="+RequestType+"&name="+str;
  FineService.getlist(post_data).then(function(response){     
    response_data    =  response.data;
    $scope.finedscp  = response_data.data;
    $scope.fine_name =  response_data.data[0];
    $scope.showpopup();
  })
  //add all selected fines
  }

  
  //show pop up for fines list  
  var savedPopup;
  
  $scope.showpopup = function() {
      $ionicPopup.show({
        templateUrl:  'choose-fine-template.html',
        title: 'Select Voilation',
        scope: $scope,
        buttons: [
          { text: 'Cancel', onTap: function(e) { return true; } },
        
        {
        text: '<b>Select</b>',
        type: 'button-positive button-small',
        onTap: function(e) {
          if (!$scope.finesfromlist) {
               //don't allow the user to close unless he enters wifi password
                e.preventDefault();
               } else{
                        fines = $scope.finesfromlist;
                        angular.forEach(fines,function(data,value){
                         
                           fine = data;
                           type = RequestType;
                           data = {'name':fine,'type':type};
                         
                          arr = $scope.selectedfines;
                          var id = arr.length + 1;
                          var found = arr.some(function (el) {
                            return el.name === fine;
                          });
                          if (!found) {  $scope.selectedfines.push(data); }
                          $scope.finesfromlist = [];
                        })
             return $scope.finesfromlist;
          }
           
        }
      },
         
        ]
      }).then(function(res) {
        console.log('Tapped!', res);
      }, function(err) {
        console.log('Err:', err);
      }, function(popup) {
        // If you need to access the popup directly, do it in the notify method
        // This is also where you can programatically close the popup:
        // popup.close();
          console.log('The popup');
          console.log(popup);
        savedPopup = popup;
      });    
  }

 //get all fines when user select it. push and remove accordingly
  $scope.finename = function(fine){
  
     if($scope.finesfromlist.indexOf(fine) == -1){
        $scope.finesfromlist.push(fine);
     } 
     else
     {
        $scope.finesfromlist.splice(fine,1);
     }

  }

  

   //update new driver 
   $scope.updatedriver = function(driver){

    $scope.driverid =  driver.driver_id;
    storageService.save('driverselectedtemp','yes');
   }
   //fine delete

  $scope.onItemDelete = function(item){
    console.log($scope.selectedfines);
    $scope.selectedfines.splice(item,1);
  } 
   //we will toggle fine user here.
  $scope.togglefine = function(){
    RequestType = $scope.alternative;
    
    FineService.getfinetype("data="+RequestType).then(function(response){
  
     response_data = response.data;
     //console.log(response_data);
     $scope.finelists = response_data.data;
     $scope.alternative = test(RequestType);
     $ionicScrollDelegate.scrollTop(true)
     console.log($scope.alternative);
 });  
  }

  $scope.image= []; 
  //take picture
 

 //confirm vilation and take user to print page

  $scope.ConfirmFine = function(){
   // console.log($scope.driverid);

    var fine_data =  {'fines':$scope.selectedfines,'info':parsed};
    console.log(fine_data);  
    storageService.save('finesdetailtemp',fine_data);
    $location.path('/app/confirm/tempfine');
    //user activity
    storageService.save('activity',+new Date);
  }
})
.controller('ConfirmTempFineCtrl',function($scope,storageService,FineService,$window,$ionicLoading,geoLocationService,$location,$ionicModal,RegService,$http){
  
  $scope.date = new Date(); 

  var data =  storageService.get('finesdetailtemp');
  var parsed = JSON.parse(data);

  //get logined user data

   var logineduser  = storageService.get('user');
   var pasedloginedUser = JSON.parse(logineduser); 

   $scope.finedby = pasedloginedUser;
   $scope.dataforfine =  parsed;
   
  //console.log($scope.dataforfine);  
  $scope.refreshData = function() {
    geoLocationService.getLocation().then(function(position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
        $scope.latitude = lat;
        $scope.longitude = lng;  

        $http.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+
        lat+","+lng+"&sensor=true&callback=JSON_CALLBACK").then(function(response){       
         var locationDetails=response.data.results[0].formatted_address;
         console.log(locationDetails);
         $scope.currentlocation = locationDetails;
        })     
    });
  };

  $scope.refreshData();
  //get signature image data here
  $scope.$on('image',function(event,obj){
    console.log(obj);
    $scope.imageData =  obj;
    console.log($scope.imageData);
  });


  $ionicModal.fromTemplateUrl('templates/signature.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  });
  
 //close login
 $scope.closeSIgnatrOnce =function(){
 
    $scope.signaturemodal.hide();
 }   
  $ionicModal.fromTemplateUrl('templates/signature.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.signaturemodal = modal;
  });

  $scope.clearOk = function(){

    var content = document.getElementById("canvas1");
   
     var ctx = content.getContext('2d');
     ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
          
  }

 
  // Open the login modal
  $scope.takesignature = function() {   
    $scope.signaturemodal.show();
  };
  
  
  // Create the login modal that we will use later
  $ionicModal.fromTemplateUrl('templates/successtemp.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  });
  
 //close login
 $scope.closeLoginOnce =function(){

  $scope.modal.hide();
  $scope.succesonIssue =true;
  $location.path('app/dashboard');
 }   
  // Open the login modal
  $scope.login = function() {
    $scope.modal.show();
  };

  $scope.showPrompt = function() {
     var confirmPopup = $ionicPopup.prompt({
       title: 'Location Not Found?',
       template: 'Unable to find your Geo location .Turn your GPS on!!',
       inputType: 'text',
       inputPlaceholder: 'MIA...'
     });
     confirmPopup.then(function(res) {
         $scope.refreshData();
        // console.log('Here');
     });
      
   };
  
  $scope.issueandPrintfine= function(){

    var latitude =  $scope.latitude;
    if(latitude == null || latitude == false){    
      $scope.showPrompt();
      return ;
      }else{
        console.log(latitude);
       }
  
    // Setup the loader
    $ionicLoading.show({
      content: '<i class="icon ion-looping"></i> Loading',
      animation: 'fade-in',
      showBackdrop: true,
      maxWidth: 200,
      showDelay: 0
    });
  
    var data = {'fine':$scope.dataforfine,'latitude':$scope.latitude,'longitude':$scope.longitude,'finedby':pasedloginedUser,'signature':$scope.imageData};
    
    RegService.issuefine(data).then(function(response){
    
     response_data = response.data;
     response_code = response_data.code;
     if(response_code === '200'){
       $scope.responsedata = response.data.data;
       $ionicLoading.hide();
       $scope.login();
       //console.log($scope.responsedata);
       //user activity
       storageService.save('activity',+new Date);
     
     }
    });

  }


   //print file here

  $scope.printfile = function(){ 

     var content = document.getElementById("printdata");

    cordova.plugins.printer.isAvailable(
    function (isAvailable,installedAppIds) {
      
        if(isAvailable){
        //console.log(installedAppIds);  
        plugin.printer.print(content, { appId: 'com.zebra.android.zebrautilities' });  

        }else{
          alert('Service NOT available');
        }
         
    }
   );
  }
})
