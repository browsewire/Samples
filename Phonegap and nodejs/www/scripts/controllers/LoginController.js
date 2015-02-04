'use strict';

/**
 * @ngdoc function
 * @name appApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the appApp
 */
angular.module('HccApp')
.controller('LoginController',function($scope,$location,$rootScope,Authentication,$cordovaFacebook,storageService,$cordovaDialogs){

  $rootScope.user_valid_icon =  false;
  //initialize user
  $scope.user = {};

  //login user
  $scope.login = function() {
    
    var data = 'email_address='+$scope.user.email+'&password='+$scope.user.password;

     Authentication.login(data).then(function(response){
       console.log(response);
      var status = response.success;
      //if true
      if(status == true){
         var data_test = response.data;
         storageService.save('user_data',data_test);  
         $location.path('/dashboard');
       }else{
        $cordovaDialogs.alert(response.message, 'Error', 'OK');    
       }
     });
  };

  //route to signup page
  $scope.signup = function(){
    $location.path('/signup');
  }

 //facebook login
  $scope.loginfacebook =  function(){
    //check user status first
       $cordovaFacebook.getLoginStatus()
          .then(function(success) {
            var status =  success.status;
            if(status == 'unknown'){
                //if unknown let him sign in using fb 
                    $cordovaFacebook.login(["public_profile", "email", "user_friends"])
                    .then(function(success) {
                      var status = success.status;
                      if(status === 'connected'){
                         //redirect user to signup and save his instance
                         var response = success.authResponse;                     
                         storageService.save('LoggedInFb',response);
                         $location.path('/signup');
                      }
                     
                    }, function (error) {
                      // error
                      console.log(error);
                    });
            }
            // success
          }, function (error) {
              // error
              console.log(error);
          });
  }
})

.controller('SignupController',function($scope,$rootScope,Authentication,$cordovaDialogs,storageService,$cordovaFacebook,$location){
     
     $rootScope.user_valid_icon =  false; 
    //initialize user
     $scope.user = {};
    //check if user is sign in through facebook
     $cordovaFacebook.getLoginStatus()
          .then(function(success) {
             var status =  success.status;
             console.log(status);
             if(status !== 'unknown'){
               $cordovaFacebook.api("me", ["public_profile"])
                          .then(function(success) {
                          $scope.user.first_name = success.first_name;
                          $scope.user.last_name  = success.last_name;
                          $scope.user.gender     = success.gender;
                          $scope.user.email_address = success.email;                         
                          });

                  }else{
                      //select default gender 
                      $scope.user.gender = $scope.genders[0];
                  }

            });
     //set gender
    $scope.genders = ['Please Select','male','female','other'];

    //set up cites as specified
    $scope.cities =  [
           'Please Select',
           'Bloemfontein',
           'Cape Town',
           'Durban',
           'Port Elizabeth',
           'Pretoria',
           'Johannesburg',
           'Other'
    ];
    //initial city
    $scope.user.nearest_city = $scope.cities[0];
    
   //get user data on signup

   $scope.signup = function(){   
    //validate password 
    if($scope.user.password !== $scope.user.password){
        $cordovaDialogs.alert('Password and confirm password doesn\'t match ', 'Message', 'OK');
        return;
    }

    var user_data = 'first_name='+$scope.user.first_name+
             '&last_name='+$scope.user.last_name+ 
             '&gender='+$scope.user.gender+
             '&email_address='+$scope.user.email_address+
             '&password='+$scope.user.password+
             '&conf_password='+$scope.user.conf_password+
             '&nearest_city='+$scope.user.nearest_city+
             '&contact_number='+$scope.user.contact_number;
  
    Authentication.Register(user_data).then(function(response){ 
     var status = response.success;
     //console.log(response);
      //if true
      if(status === true){
        var data_test = response.data;
        storageService.save('loggedIn','user_token_123');
        storageService.save('user_data',data_test);  
        $location.path('/dashboard');        
        $cordovaDialogs.alert('Hurray!! You are In!!','Message', 'OK');
      }else{
        $cordovaDialogs.alert(response.message,'Message', 'OK');
      }
    });

   }

});