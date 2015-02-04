'use strict';

/**
 * @ngdoc function
 * @name appApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the appApp
 */
angular.module('HccApp')
.controller('DashController',function($scope,$rootScope,Authentication,Djs){
  $rootScope.user_valid_icon =  true;

  $scope.clubxlusive =  function(){
   var item  = "auth_token="+Authentication.auth_token();
   Djs.clubxlusive(item).then(function(response){
    console.log(response);
   })
   
  }
})


//controller for galley images. feed from instagram 
.controller('InstaController',function($scope,$rootScope,instagram,$modal){
      
      $rootScope.user_valid_icon =  true; 
      $scope.pics = [];
      $scope.have = [];
       
       $rootScope.loading = true;
      //get first data
      $scope.getMore = function() {
        instagram.fetchPopular(function(response) {       
          $scope.next_url = response.pagination.next_url;
          console.log(response.data);
          $scope.process(response.data);
          $rootScope.loading = false;
        });
      };
      
      $scope.getMore();
      //load more
      $scope.loadmore = function(){

        instagram.fetchMore($scope.next_url).then(function(response){          
              $scope.next_url = response.pagination.next_url
              $scope.process(response.data);
           
        });
    
      }
     //lesser code
      $scope.process = function(data){
            for(var i=0; i<data.length; i++) {
              if (typeof $scope.have[data[i].id]==="undefined") {
                $scope.pics.push(data[i]) ;
                $scope.have[data[i].id] = "1";
              }
            }
      }

   //open image in modal with hogh resolution
  $scope.open = function (size) {

    $scope.selecteddata = size;
      
    var modalInstance = $modal.open({
      templateUrl: 'templates/modal.html',
      controller: 'ModalController', 
      size:'lg',    
      resolve: {
        items: function () {
          return $scope.selecteddata;
        }
      }
    });

    modalInstance.result.then(function (selectedItem) {
      //$scope.selected = selectedItem;
    }, function () {
     // $log.info('Modal dismissed at: ' + new Date());
    });
  };

})
//modal controller
.controller('ModalController',function($scope,$rootScope,items,$modalInstance,$cordovaSocialSharing){

 
   $scope.selectedItem = items;

   $scope.ok = function () {
   // $modalInstance.close($scope.selected.item);
   };
   //share image to social sites
   $scope.shareAnywhere = function() {
        $cordovaSocialSharing.share("HCC", null, $scope.selectedItem, null);
    }
 
   $scope.close = function () {
    $modalInstance.dismiss('cancel');
   };

})

.controller('EventController',function($scope,$rootScope,Events,Authentication){

  $rootScope.user_valid_icon =  true; 
   //user token
  var token = Authentication.auth_token();
  //get events
  $rootScope.loading = true;

  $scope.events = function(){
   var item = 'auth_token='+token;  
   Events.get(item).then(function(response){    
      $rootScope.loading = false;
      $scope.eventsall = response.data;
   });
  }

   $scope.events();

})

 //events controller
.controller('YoutubeController',function($scope,$rootScope,instagram){
  

  $rootScope.user_valid_icon =  true;
  
  $scope.feeds = [];

  instagram.video().then(function(data){     
       $scope.channelname = data.feed.author[0].name.$t;
       var data = data.feed.entry;
       //customize and sanitize data. push into scope
       for(var i=0; i<data.length; i++) {             
          var video_url = data[i].link[2].href;
          var video_id  = video_url.split('=');
          var title     = data[i].title.$t;
          var pageviews = data[i].yt$statistics.viewCount; 
          var publish   = data[i].published.$t; 
          var package_test = {id:video_id[1],title:title,view:pageviews,publish:publish};
          $scope.feeds.push(package_test);
       
        }
          
  });

   //get youtube subscribers count
  instagram.videoyou().then(function(response){
     $scope.counts =  response.subscriberCount;
  });
})
 
 //facebook feed data
.controller('FbController',function($scope,$rootScope,Events){
  
   $rootScope.loading = true;
   $rootScope.user_valid_icon =  true; 
   $scope.fbdata = [];
   
    //load fb feed
   $scope.loadfb = function(){    
   Events.fbinfo().then(function(success){      
      var data =  success.entries;
      for(var i=0; i<data.length; i++) {      
         var str = data[i].content;        
         var str=  str.replace(/href="\//g, 'href="https://www.facebook.com/');
         var author = data[i].author.name;
         var published = data[i].published;         
         var data_chunked = {content:str,author:author,publish:published};
         $scope.fbdata.push(data_chunked);          
      }
      $rootScope.loading = false;     
    })
  }

  $scope.loadfb();
  //get fb page like 
  $scope.check = function(){

    Events.FbPage().then(function(response){
      $scope.pageinfo = response;
    })
  }

  $scope.check();
})

//twitter feed controller
.controller('TweetController',function($scope,$rootScope,Events){
   
   $rootScope.loading = true;

   $rootScope.user_valid_icon =  true;
    //get timeline
   $scope.loadtweet = function(){
    Events.TwitterTimeline().then(function(response){
      $rootScope.loading = false;     
      $scope.tweets =  response;
    })
   } 

   $scope.loadtweet();

})


//dj's controller
.controller('DjController', function($scope,Djs,Authentication,$rootScope){
  
  $scope.djlist = []; 
  $rootScope.loading = true; 
  //list all djs
  $scope.listdjs = function(){
    Djs.all().then(function(response){
      $scope.djlist = response.data;
      $rootScope.loading = false;
    })
  } 

  $scope.listdjs();
  //get dj's gig guide
  $scope.getgig = function(id){
   var item = 'djid='+id+"&auth_token="+Authentication.auth_token();
   Djs.getgig(item).then(function(response){
    console.log(response);
   })

  }


}) 