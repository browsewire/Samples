// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['timer','ionic', 'starter.controllers', 'starter.services'])

.constant('ApiEndpoint', {
  url: 'http://www.vlifetech.com/'
})

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleLightContent();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider

  
  
  .state('login', {
    url: '/login',
    templateUrl: 'templates/login.html',
    controller: 'UserCtrl'
    
  })
  
  .state('profile', {
    url: '/profile',
    templateUrl: 'templates/profile.html',
    controller: 'ProfileCtrl'
    
  })
  
  .state('updatepassword', {
    url: '/updatepassword',
    templateUrl: 'templates/updatepassword.html',
    controller: 'UpdatepasswordCtrl'
    
  })
  
  .state('logout', {
    url: '/logout',
    templateUrl: 'templates/logout.html',
    controller: 'LogoutCtrl'
    
  })
  
  .state('home', {
    url: '/home',
    templateUrl: 'templates/home.html',
    controller: 'HomeCtrl',
    onEnter: function($state, Auth){
        if(!Auth.isLoggedIn()){
          $state.go('guesthome');
        }
    }
    
  })
  
  .state('guesthome', {
    url: '/guesthome',
    templateUrl: 'templates/guesthome.html',
    controller: 'GuesthomeCtrl',
    onEnter: function($state, Auth){
        if(Auth.isLoggedIn()){
          $state.go('home');
        }
    }
    
  })
  
  // Each tab has its own nav history stack:

  .state('church', {
    url: '/church/:churchid',
    templateUrl: 'templates/church.html',
    controller: 'ChurchCtrl'
  
  })
  
  .state('live', {
    url: '/live/:churchid',
    templateUrl: 'templates/live.html',
    controller: 'LiveCtrl'
  
  })

    // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/home');

});
