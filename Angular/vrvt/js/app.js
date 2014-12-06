var baseurl = "http://www.gamtes.com";
angular.module('vrvt', ['ngCordova','ionic','starter.controllers','mobile-angular-ui'])


.config(function($compileProvider){
  $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|tel):|data:image\//);
})

.run(function($ionicPlatform,$rootScope) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
     $rootScope.$on('$locationChangeStart',function(event,next,current){   
       $rootScope.$broadcast("ROUTE_CHANGED",next);
  });
  });
})

.config(function($httpProvider){
        //initialize get if not there
      if (!$httpProvider.defaults.headers.get) {
          $httpProvider.defaults.headers.get = {};    
      }
      //disable IE ajax request caching
      $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
      $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // $httpProvider.defaults.cache = true;
   })

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider

    .state('app', {
      url: "/app",
      abstract: true,
      templateUrl: "templates/menu.html",
      controller: 'AppCtrl'
    })

    .state('app.fines', {
      url: "/fines",
      views: {
        'menuContent' :{
          templateUrl: "templates/fines.html",
          controller:'SearchFineCtrl'
        }
      }
    })
     .state('app.register', {
      url: "/register",
      views: {
        'menuContent' :{
          templateUrl: "templates/register.html",
          controller:'RegisterFineCtrl'
        }
      }
    })
      .state('app.temp', {
      url: "/temp/:driverId",
      views: {
        'menuContent' :{
          templateUrl: "templates/temporayfine.html",
          controller:'TempFineCtrl'
        }
      }
    })
    .state('app.messages', {
      url: "/messages",
      views: {
        'menuContent' :{
          templateUrl: "templates/messages.html",
          controller: 'MessagesCtrl',
          resolve:{
            messages: function(SearchService){
             return SearchService.getmessages();
          }
        }
      }
    }
    })
    .state('app.create', {
      url: "/messages/create",
      views: {
        'menuContent' :{
          templateUrl: "templates/createmessage.html",
          controller: 'DashCtrl',
      }
    }
    })
    
    .state('app.message', {
      url: "/messages/:messageId",
      views: {
        'menuContent' :{
          templateUrl: "templates/messagesdetail.html",
          controller: 'MessagesCtrl',
      }
    }
    })
    
   
    .state('app.dashboard', {
      url: "/dashboard",
      views: {
        'menuContent' :{
          templateUrl: "templates/dashboard.html",
          controller: 'DashCtrl',
          resolve:{
            messages: function(SearchService){
             return SearchService.getmessages();
          }
         }
        }
      }
    })

    .state('app.single', {
      url: "/vehicle/:vehicleId",
      views: {
        'menuContent' :{
          templateUrl: "templates/vehicle_detail.html",
          controller: 'VehicleDetailCtrl'
         
        
      }
    }
      
    })
    .state('app.driver', {
      url: "/driver/add/:vehicleId",
      views: {
        'menuContent' :{
          templateUrl: "templates/driver.html",
          controller: 'DriverCtrl'
        }
      }
    })
    .state('app.search',{
      url:'/search/vehicle',
      views:{
        'menuContent':{
          templateUrl:"templates/search.html",
          controller:'VehicleCtrl'
        }
      }
    })
    .state('app.issuefine',{
       url:'/issuefine/:vehicleType/:driverId/:vehicleId',
       views:{
        'menuContent':{
          templateUrl:'templates/issuefine.html',
          controller:'IssueFineCtrl'
        }
       }
    })
    .state('app.confirm',{
      url:'/confirm/fine',
      views:{
        'menuContent':{
          templateUrl:'templates/confirmfine.html',
          controller:'ConfirmFineCtrl'
        }
      }

    })
    .state('app.tempfine',{
      url:'/confirm/tempfine',
      views:{
        'menuContent':{
          templateUrl:'templates/confirmtempfine.html',
          controller:'ConfirmTempFineCtrl'
        }
      }

    })
    .state('app.signature',{
       url:'/get/signature',
       views:{
        'menuContent':{
         templateUrl:'templates/signature.html',
         controller: 'SignatureCapCtrl'
        }
       }
    })
    
     .state('login', {
      url : '/login',
      templateUrl:'templates/userlogin.html',
      controller:'LoginCtrl',
      resolve: {
        taskstatus: function(Auth) {
          return Auth.checkuser() ;
        }
      }
      
     });

    
  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/login');
})

.factory('Auth',function($rootScope,$http,$location,$sanitize,storageService){

 return {
  login:function(credentials){
    //login user for first time and send to set pin
    var sanitizecredentials = function(credentials){
      return data =
         "email="+$sanitize(credentials.email)+
         "&password="+$sanitize(credentials.password);
    
    };

    return $http.post(baseurl+'/v1/auth/firstlogin',sanitizecredentials(credentials));
  
  },
  SetPin:function(pindata){
    //set user pin
    return $http.post(baseurl+'/v1/auth/setpin',pindata);
  },
  CheckPin:function(pin){  
      //alert(pin+"service");
     return $http.post(baseurl+'/v1/auth/pin',pin).then(function(response){         
         return response.data;
      });
   },
  loginuser:function(userdata){
     return $http.post(baseurl+'/v1/auth/login',userdata);
   },

   checkuser:function(){

    return storageService.get('user');
   }
  
}


})
//serach service for vehicle searching 
.factory('SearchService',function($rootScope,$http,$sanitize){

  return{
      search:function(items){

      return $http.post(baseurl+'/v1/search/vehicle',items); 
 
      },
      Detail:function(params){

        return $http.post(baseurl+'/v1/vehicle/detail','id='+params);
      },
      getmessages:function(){
       
       return $http.post(baseurl+'/v1/messages'); 

      },
      getmessagestrail:function(id){
         return $http.post(baseurl+'/v1/messages/trail','messageId='+id); 

      },
      replymessage:function(querysting){
        return $http.post(baseurl+'/v1/messages/trail/reply',querysting);  

      },
      mainalert:function(querysting){
         return $http.post(baseurl+'/v1/messages/main',querysting);  
      },
      registerdetail:function(params){
        return $http.post(baseurl+'/v1/vehicle/registerdetail','id='+params);

      }


  };
})
//serach service for vehicle searching 
.factory('DriverService',function($rootScope,$http,$sanitize){

  return{
      country:function(){

       return $http.post(baseurl+'/v1/driver/country'); 
 
      },
      status:function(){

        return $http.post(baseurl+'/v1/driver/status');
      },
      register:function(data){

        return $http.post(baseurl+'/v1/driver/register',data);
      }

  };
})

//temporay registration and finr service for vehicle 
.factory('RegService',function($rootScope,$http,$sanitize){

  return{
      Check:function(data){

       return $http.post(baseurl+'/v1/register/check',data); 
 
      },
      savedriver:function(data){

        return $http.post(baseurl+'/v1/register/adddriver',data);
      },
      issuefine:function(data){

        return $http.post(baseurl+'/v1/register/issuefine',data);
      }

  };
})

//serach service for vehicle searching 
.factory('FineService',function($rootScope,$http,$sanitize){

  return{
      getfinetype:function(type){
     
       return $http.post(baseurl+'/v1/fines/gettype',type); 
 
      },
      getlist:function(data){

        return $http.post(baseurl+'/v1/fines/getlist',data);
      },
      
      issuefine:function(data){

        return $http.post(baseurl+'/v1/fines/issuefine',data);
      },
      serachfine:function(data){
        return $http.post(baseurl+'/v1/fines/search',data);
      }


  };
})


.factory('storageService', function ($rootScope) {

    return {
        
        get: function (key) {
           return localStorage.getItem(key);
        },

        save: function (key, data) {
           localStorage.setItem(key, JSON.stringify(data));
        },

        remove: function (key) {
            localStorage.removeItem(key);
        },
        
        clearAll : function () {
            localStorage.clear();
        }
    };
})

.filter('asYear',function(){

 return function(date){
  return Date.parse(date);
 }

})
.filter('toupperCase',function(){
       return function(string){         
              str = string;           
              return str.charAt(0).toUpperCase() + str.slice(1);
       }
   })

.factory('geoLocationService',['$q', function ($q) {
  return {
    getLocation: function() {
      var q = $q.defer();

      navigator.geolocation.getCurrentPosition(function(position) {
        q.resolve(position);
      }, function(error) {
        q.reject(error);
      });

      return q.promise;
    }
  }
   
   
  }])

 .filter('truncate', function () {
        return function (text, length, end) {
            if (isNaN(length))
                length = 10;
            if (end === undefined)
                end = "...";

            if (text.length <= length || text.length - end.length <= length) {
                return text;
            }
            else {
                return String(text).substring(0, length-end.length) + end;
            }
        };
    })
 .directive("signaturedir", ['$document', '$log', '$rootScope', function ($document, $log, $rootScope) {
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
           
            var ctx = element[0].getContext('2d');

            ctx.canvas.width = window.innerWidth - 30;

            // the last coordinates before the current move
            var lastPt;

            function getOffset(obj) {
                return { left: 15, top: 116 }; //Got a fixed offset
            }

            attrs.$observe("value", function (newValue) {
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            });

            element.on('touchstart', function (e) {             
                e.preventDefault();
                ctx.fillRect(e.touches[0].pageX - getOffset(element).left, e.touches[0].pageY - getOffset(element).top, 2, 2);
                lastPt = { x: e.touches[0].pageX - getOffset(element).left, y: e.touches[0].pageY - getOffset(element).top };
                  
            });
            element.on('touchmove', function (e) {
        
                e.preventDefault();
                if (lastPt != null) {
                    ctx.beginPath();
                    ctx.moveTo(lastPt.x, lastPt.y);
                    ctx.lineTo(e.touches[0].pageX - getOffset(element).left, e.touches[0].pageY - getOffset(element).top);
                    ctx.stroke();
                }
                lastPt = { x: e.touches[0].pageX - getOffset(element).left, y: e.touches[0].pageY - getOffset(element).top };
                
            });

            element.on('touchend', function (e) {
                e.preventDefault();
                lastPt = null;
                 var imagedata = ctx.canvas.toDataURL();     
                  console.log(imagedata);
                  $rootScope.$broadcast('image',imagedata);
            });
        }
    };
}]);

