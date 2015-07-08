angular.module('starter.controllers', [])

//  live event controller to show live events scheduled 
.controller('LiveCtrl', function($scope, $http, $state, $window, $stateParams, Church) {

    // fetech live event of slected clients  
    Church.Live($stateParams.churchid).then(function(response) {
    $scope.church= response;
    
    // define countdown 
    var countdown  = Date.parse(response.Liveevent.startdate +'T'+ response.Liveevent.start_time);
    var ctime = new Date(response.currentTime);
   
     $scope.countdownVal = 0;
     if(countdown > ctime){
     $scope.countdownVal = (countdown - ctime)/1000;
     }
     
   
    });
    
    
})


//  Church controller to show Church details
.controller('ChurchCtrl', function($scope,$http,$state, $window, $stateParams, Church) {

    Church.Detail($stateParams.churchid).then(function(response) {
    $scope.church= response;
    });
    
    Church.Getfav($window.localStorage['user']).then(function(response) {
     $scope.favouritechannel = response;
    });
    
})


//  User controller to show login/logout/signup
.controller('UserCtrl', function($scope, $state, $window, Auth) {
 
 $scope.authorization = {
    username: '',
    password : ''   
  };
    
  $scope.signIn = function(form) {
    if(form.$valid) {
    Auth.login($scope.authorization.username,$scope.authorization.password).then(function(response) {
    Auth.setUser({
      user: response.User.id
    });
    
    $window.location='/#home';
     });
    }
  };

})

//  Profile controller to show/update user Profile
.controller('ProfileCtrl', function($scope,$http, $state, $window, Auth) {

     $scope.token = $window.localStorage['user'];
  
     Auth.Profile($window.localStorage['user']).then(function(response) {
     $scope.profile = response;
     });
     
      
     

     $scope.updateprofile = function(){
      
        $http({ 
        method: 'post', 
        url: 'http://www.vlifetech.com/updateprofile', 
        params: {
           name:$scope.profile.User.name,
           address1:$scope.profile.User.address1,
           address2:$scope.profile.User.address2,
           city:$scope.profile.User.city,
           state:$scope.profile.User.state,
           country:$scope.profile.User.country,
           zip:$scope.profile.User.zip,
           user_id:$window.localStorage['user']
        }
    
    }).success(function(response){
        if(response.User){
        $scope.profile = response;
        $scope.error = 'Profile Updated';
        }else{
        $scope.error = 'Invalid Information';
        }
        }).error(function(error){
        $scope.error = 'Invalid Information';
    });

};



})


//  UpdatepasswordCtrl controller to update user password
.controller('UpdatepasswordCtrl',
function($scope, $http, $log, $location,$window){
  $scope.error = '';
  $scope.changepassword = function(){
   
   $http({ 
    method: 'post', 
    url: 'http://www.vlifetech.com/updatepassword', 
    params: {
       current_pass:$scope.oldpassword,
       password:$scope.password,
       confirm_password:$scope.confirmpassword,
       user_id:$window.localStorage['user']
    }

}).success(function(response){
    $scope.error = response;
    }).error(function(error){
     $scope.error = response;
});
   
   };
   
})

//  LogoutCtrl controller to logout user
.controller('LogoutCtrl',function($scope,$state, $http, $log, $location, $window ,Auth){
   Auth.logout();
   $window.location='/#dash';
})

//  HomeCtrl controller to list all church order by live events schedules
.controller('HomeCtrl', function($scope, $http, $window, Church, Auth) {

    $scope.authtoken = Auth.getUser();
    
    $scope.appaddtoav = function(client_id,action){
      Church.Addfav(client_id,action).then(function(response) {
       $scope.favouritechannel = response;
       console.log(response);
      });
    }
    //console.log($scope.authtoken);
    Church.List().then(function(response) {
      $scope.allchurch = response;
    });
    
    Church.Getfav($window.localStorage['user']).then(function(response) {
     $scope.favouritechannel = response;
     //console.log(response);
    });
    
    
    // get all churched by location and live schedule
    var mysrclat= 0; var mysrclong = 0;
      
    navigator.geolocation.getCurrentPosition(function (position) {
            mysrclat = position.coords.latitude; 
            mysrclong = position.coords.longitude;
            
            Church.Bylocation(mysrclat,mysrclong).then(function(response) {
               $scope.locationchannel = response;
            });
    });




    $scope.bylocation = false;
    $scope.favourite = false;
    $scope.denomination = true;
    
    $scope.toggleListfav = function() {
            $scope.favourite =true;
            $scope.denomination = false;        
            $scope.bylocation = false;
           
    };
    
    $scope.toggleListden = function() {
            $scope.denomination =true;
            $scope.favourite = false;
            $scope.bylocation = false;
    };
    
    $scope.togglebylocation = function() {
            $scope.denomination =false;
            $scope.favourite = false;
            $scope.bylocation = true;
            
    };  
  
})


//  GuesthomeCtrl controller to list all church order by live events schedules for guest userd(not loggedin)
.controller('GuesthomeCtrl', function($scope, $http, $window, Church, Auth) {
    Church.List().then(function(response) {
    $scope.allchurch = response;
    });
  // get all churched by location and live schedule
    var mysrclat= 0; var mysrclong = 0;
      
    navigator.geolocation.getCurrentPosition(function (position) {
            mysrclat = position.coords.latitude; 
            mysrclong = position.coords.longitude;
            Church.Bylocation(mysrclat,mysrclong).then(function(response) {
               $scope.locationchannel = response;
            });
    });
     
    $scope.bylocation = false;
    $scope.favourite = false;
    $scope.denomination = true;
    
    $scope.toggleListfav = function() {
            $scope.favourite =true;
            $scope.denomination = false;        
            $scope.bylocation = false;
           
    };
    $scope.toggleListden = function() {
            $scope.denomination =true;
            $scope.favourite = false;
            $scope.bylocation = false;
    };
    
    $scope.togglebylocation = function() {
            $scope.denomination =false;
            $scope.favourite = false;
            $scope.bylocation = true;
            
    }; 
})






