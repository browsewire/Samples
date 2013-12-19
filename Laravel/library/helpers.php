<?php

class Helpers {
	public static $timestamps = true;
	
   public static function checkUser($email)
			{
			$checkEmail = User::where('email',$email)->first();
			 return $checkEmail;
			}
			
   public static function error($error){
		echo View::make('error')->with('error',$error);
	   }	
	   
	   
   public static function getByUsername($username)
			{
				$get = User::where('username',$username)->first();
				 return $get;
			}
 public static function getUserProfilePic($uid){
	 
	 	 $get=User::where('id',$uid)->first()->profile_picture;
	 	 if($get){
			 $profile_picture_small="img/profile_25"."/".$get;
			 
			 if(!file_exists($profile_picture_small)){
				return	$profile_picture_small =URL::to('img/profile_25')."/profile.jpg";
				}
			else{
				return $profile_picture_small;
				}
		}else{
			return	$profile_picture_small =URL::to('img/profile_25')."/profile.jpg";
			}
	}


 public static function getUserProfilePicLarge($uid){
	 
	 $get=User::where('id',$uid)->first()->profile_picture;
	 	 
		 $profile_picture="img/users"."/".$get;
		 
		if($get){ 
			 if(!file_exists($profile_picture)){
				return	$profile_picture =URL::to('img/users')."/profile.jpg";
				}
			else{
				return $profile_picture;
				}
			}
		else{
			 return	$profile_picture =URL::to('img/users')."/profile.jpg";
			}	
	 
	 }
 	   
 public static function getTime($time)
	{
		
		    $timezone = date_default_timezone_set ("Asia/Calcutta");
		    $current_time= time($timezone); 
		    $posted_time = strtotime($time);
		    $time_difference = $current_time - $posted_time; 
		    $hours= floor( $time_difference / 3600    );
		    $minutes= intval(($time_difference/60)%60);
		    $message = $hours . " hours ago " ;
		    $message_min= $minutes . " minutes ago";
		    $message_seconds = " a few seconds ago";  
	        $posted_date =  date(" M d " , strtotime($time) );
		 //   $posted_time = date(" h:i a "    , strtotime($time));    
		    $message_day = $posted_date;   
		
		if($hours < 1)
		{  
		 if($minutes < 1)
			{
		      return $message_seconds;
		     	}
		     	else
		       {
			      return $message_min ; 
	             }
	 	     }
		     elseif($hours > 24 )		     	     
		     {
			 	return $message_day; 
			  } 
		    else 
		    {
			     return $message;
			 } 
	 }
	  
 public static  function limit_words($string, $word_limit)
	{
		$words = explode(" ",$string);
		return implode(" ", array_splice($words, 0, $word_limit));
	} 
}
