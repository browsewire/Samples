angular.module('starter.services', [])

//factory for authentication and login signup 

.service('Session', function() {
  this.create = function(user) {
    this.user = user;
  };
  this.destroy = function() {
    this.user = null;
  }
  return this;
})


.factory('Auth', function($http,$q, $rootScope, $window, Session, ApiEndpoint) {
    
    var baseurl = ApiEndpoint.url;
     var _user = $window.localStorage['user'];
     var setUser = function (user) {
    // console.log(user);
     
        _user = user.user;
        $window.localStorage['user'] =  _user;
     }
   
	  return {
        login: function(username, password) {
            var Url = baseurl+'applogin?email='+username+'&password='+password;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

           return defer.promise;
        },
        setUser: setUser,
        isLoggedIn: function () {
           return $window.localStorage['user'] ? true : false;
        },
        getUser: function () {
           return $window.localStorage['user'];
        },
        logout: function () {
          $window.localStorage.removeItem('user');
           _user = null;
        },
        Profile: function(user_id) {
            var Url = baseurl+'getprofile?user_id='+user_id;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
       
       
  
    }
        
 })
 
 
.factory('Church', function($http, $q, ApiEndpoint,$window) {
    
    var baseurl = ApiEndpoint.url;
	  return {
        Live: function(churchid) {
            var Url = baseurl+'getclientsevent/'+churchid;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
        
        Detail: function(churchid) {
            var Url = baseurl+'getclientdetail/'+churchid;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
        Addfav: function(client_id,action) {
            var Url = baseurl+'appaddtoav?user_id='+$window.localStorage['user']+'&client_id='+client_id+'&action='+action;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
        Getfav: function(user_id) {
            var Url = baseurl+'getfavouritechannel?user_id='+user_id;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
        List: function() {
            var Url = baseurl+'getclientlist';
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        },
        Bylocation: function(mysrclat,mysrclong) {
            var Url = baseurl+'getchannelbylocation?mysrclat='+mysrclat+'&mysrclong='+mysrclong;
            var defer = $q.defer();
            $http.get(Url).
            success(function(data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function(data, status, headers, config) {
                defer.reject();
            });

            return defer.promise;
        }
    }
        
 }); 
 