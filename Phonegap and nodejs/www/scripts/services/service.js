'use strict';

/**
 * @ngdoc function
 * @name appApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the appApp
 */

var baseurl ="http://huaweicultureclub.co.za/admin/index.php/hcc_api/";
angular.module('HccApp')
 //factory for authentication and login signup 
.factory('Authentication',function($http,storageService,$q){

  return{
    login:function(item){

           storageService.save('loggedIn','user_token_123');

           var Url = baseurl+'login';
           var defer = $q.defer();

           $http.post(Url,item).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });

            return defer.promise;
    },

    logout:function(){
       storageService.remove('loggedIn');
    },

    Register:function(item){
           var Url = baseurl+'register';
           var defer = $q.defer();

           $http.post(Url,item).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });

            return defer.promise;

    },

    auth_token:function(){
      var user_data =  storageService.get('user_data');
      var data = JSON.parse(user_data);
      return  data[0].auth_token;
    }

  }

})
 
 //localstorage factory
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

 
//events service
.factory('Events', function ($rootScope,$http,$q) {

    return {
        get: function (item) {
           var Url = baseurl+'events';
           var defer = $q.defer();

           $http.post(Url,item).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });

            return defer.promise;
        },
       fbinfo:function(){
           var Url = "http://admin.hututoo.com/gandg-facebook";
           var defer = $q.defer();

           $http.get(Url).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });
            return defer.promise;

       },
       TwitterTimeline:function(){
           var Url = "http://admin.hututoo.com/gandg-tweets/gandg-tweets.php";
           var defer = $q.defer();

           $http.get(Url).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });
            return defer.promise;
       } ,
       FbPage:function(){
           var Url = "http://graph.facebook.com/250441934828";
           var defer = $q.defer();

           $http.get(Url).
              success(function (data, status, headers, config) {
                  defer.resolve(data);
              }).
              error(function (data, status, headers, config) {
                  defer.reject();
              });
            return defer.promise;
       } 

      
    };
})
  //instagram pics and youtube service
 .factory('instagram', ['$http','$q','$rootScope',
        function($http,$q,$rootScope) {
            return {
                fetchPopular: function(callback) {
                    var access_token = "295178498.76b13ab.e57b1dcc526c4095a7adb641dadf1e58";
                    var user_id = "1269326164";
                    var endPoint = "https://api.instagram.com/v1/users/"+user_id+"/media/recent/?access_token="+access_token+"&callback=JSON_CALLBACK";

                    $http.jsonp(endPoint).success(function(response) {
                        callback(response);
                    });
                },
               fetchMore:function(endPoint){

                    var defer = $q.defer();
                    $http.jsonp(endPoint+"&callback=JSON_CALLBACK").
                    success(function (data, status, headers, config) {
                        defer.resolve(data);
                    }).
                    error(function (data, status, headers, config) {
                        defer.reject();
                    });
                   return defer.promise;
                
               },
               video:function(){
                var defer = $q.defer();
                /*https://www.googleapis.com/youtube/v3/search?key=AIzaSyDs6Xom8tFnbowHczc7jZvliMUmEl1Qro0&channelId=GGPRODUCTIONSSA&part=snippet,id&order=date&maxResults=20&callback=JSON_CALLBACK"*/
                    $http.jsonp("http://gdata.youtube.com/feeds/api/users/GGPRODUCTIONSSA/uploads?alt=json&max-results=10&callback=JSON_CALLBACK").
                    success(function (data, status, headers, config) {
                        defer.resolve(data);
                    }).
                    error(function (data, status, headers, config) {
                        defer.reject();
                    });
                   return defer.promise;
               },
               videoyou:function(){
                    var defer = $q.defer();
                    var url = "http://admin.hututoo.com/youtube/index.php";
                
                    $http.get(url).
                    success(function (data, status, headers, config) {
                        defer.resolve(data);
                    }).
                    error(function (data, status, headers, config) {
                        defer.reject();
                    });
                   return defer.promise;
               }  
            }
        }
    ])

 .factory('Djs',function($http,$q,$rootScope,Authentication){
  return{
      all:function(){
          var defer = $q.defer();
          var auth_token = Authentication.auth_token();
          var Url = baseurl+'dj';
          $http.post(Url,'auth_token='+auth_token).
           success(function (data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function (data, status, headers, config) {
                defer.reject();
            });
           return defer.promise;
      },
       getgig:function(item){
          var defer = $q.defer();
         
          var Url = baseurl+'djgigs';
          $http.post(Url,item).
           success(function (data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function (data, status, headers, config) {
                defer.reject();
            });
           return defer.promise;
      },
      clubxlusive:function(item){
          var defer = $q.defer();
         
          var Url = baseurl+'clubexclusives';
          $http.post(Url,item).
           success(function (data, status, headers, config) {
                defer.resolve(data);
            }).
            error(function (data, status, headers, config) {
                defer.reject();
            });
           return defer.promise;

      }
  }
  
 })


