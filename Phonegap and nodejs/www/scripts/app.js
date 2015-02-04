 var app = angular.module('HccApp', [
  'ngRoute',
  'ngTouch',
  'ngCordova',
  'ngAnimate', 
  'ngSanitize', 
  'angularMoment',
  'mobile-angular-ui',  
  'mobile-angular-ui.drag',
  'ui.bootstrap'
]);
 

app.config(function($compileProvider){
  $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|tel):|data:image\//);
})

//whitelist youtube link
app.config(["$sceDelegateProvider", function($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist([
        'self',
        "http://www.youtube.com/embed/*"
    ]);
}]);


app.run(function($rootScope, $location,storageService) {    
    // Needed for the loading screen
    $rootScope.$on('$routeChangeStart', function(event, next, current){

       $rootScope.globals = storageService.get('loggedIn');
       $rootScope.loading = true;  
     
      if($rootScope.globals !== null){

         if($location.path() == '/' || $location.path() == '/signup'){
          $location.path('/dashboard');

        }        
      }else{
         if($location.path() == '/' || $location.path() == '/signup'){
          return;
         }else{
           $location.path('/');
         }
      }
    });

    $rootScope.$on('$routeChangeSuccess', function(){
      $rootScope.loading = false;
    });

});

app.config(function($httpProvider){
        //initialize get if not there
      if (!$httpProvider.defaults.headers.get) {
          $httpProvider.defaults.headers.get = {};    
      }
      //disable IE ajax request caching
      $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
      //send content type headers
      $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // $httpProvider.defaults.cache = true;
   })

//routes
app.config(function($routeProvider) {
  $routeProvider.when('/',  {
        templateUrl: 'templates/login.html',
        controller:  'LoginController',
        reloadOnSearch: false
      });
  $routeProvider.when('/signup',  {
        templateUrl: 'templates/signup.html',
        controller:  'SignupController',
        
      });
   $routeProvider.when('/signupfb',  {
        templateUrl: 'templates/signupfb.html',
        controller:  'SignupController',
        
      });
  $routeProvider.when('/dashboard',  {
            templateUrl: 'templates/dashboard.html', 
            controller:  'DashController',
      });
  $routeProvider.when('/events',     {
           templateUrl: 'templates/events.html',
           controller:  'EventController'
     });
  $routeProvider.when('/you_tube',    {
           templateUrl: 'templates/you_tube.html',         
           controller:  'YoutubeController'
    }); 
  $routeProvider.when('/djs',    { 
           templateUrl: 'templates/djs.html',        
           controller:  'DjController'
     }); 
  $routeProvider.when('/facebook',      {
           templateUrl: 'templates/facebook.html',       
           controller:  'FbController'
     }); 
  $routeProvider.when('/twitter',   {
           templateUrl: 'templates/twitter.html',    
           controller:  'TweetController'
     });   
  $routeProvider.when('/gallery',     {
           templateUrl: 'templates/gallery.html',       
           controller:  'InstaController'
     });
});


 //filter for sanitization

  app.filter('to_trusted', ['$sce', function($sce){
           return function(text) {
            return $sce.trustAsHtml(text);
        };
  }]);
  
  app.filter('decode', function() {
    return function(htmlString){
     if(htmlString){
          var decoded = htmlString.replace(/&amp;/g, '&');
          return decoded;                    
      }     
    }
  });

  app.filter('trusted_url', ['$sce', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
}]);


//youtube directive
app.directive('myYoutube', function($sce) {
  return {
    restrict: 'EA',
    scope: { code:'=' },
    replace: true,
    template: '<div style="height:250px;"><iframe style="overflow:hidden;height:100%;width:100%" width="100%" height="100%" ng-src="{{url}}" frameborder="0" allowfullscreen></iframe></div>',
    link: function (scope) {
        scope.$watch('code', function (newVal) {
           if (newVal) {
               scope.url = $sce.trustAsResourceUrl("http://www.youtube.com/embed/" + newVal);
           }
        });
    }
  };
});
//
// For this trivial demo we have just a unique MainController 
// for everything
//
app.controller('MainController', function($rootScope,Authentication,$location, $scope,$cordovaFacebook,storageService){

  $rootScope.user_valid_icon =  true; 
 
  $scope.logout =  function(){
   Authentication.logout();
   $cordovaFacebook.logout()
    .then(function(success) {      
      storageService.remove('LoggedInFb');
    }, function (error) {
      // error
    });

   $location.path('/');
  }
});