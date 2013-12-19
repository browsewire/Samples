<?php

class HomeController extends BaseController {

  public function index($page=NULL,$page2=NULL)
	{	
	
		$username=$page;
		if($page2=="settings" && Auth::user()==null){
			return Redirect::to('/');
			}
		$usernameCheck=$this->checkUserName($username);
		if($usernameCheck){
			if($page2!='proile'){			
					//user timeline view
					if($page2 && $page2!='compose'){						
						 $getData=$this->getUserPost($this->getTypeValue($this->checkType($page2)),$usernameCheck->id);
						
						}
					else{
							$getData=$this->getTimeline($this->getTypeValue($this->checkType($page2)),$usernameCheck->id);
							
						}	
				}
			else{
				$getData=Post::where('type_id',$this->getTypeValue($this->checkType($page2)))
							->where('user_id',$usernameCheck->id)
							->orderBy('id', 'desc')
							->get();
				
				$getData=	DB::table('post')
											->whereIn(function($query)
											{
												$query->select(DB::raw(1))
													  ->from('published')
													  ->whereRaw('published.user_id = post.user_id');
											})
											->get();
				}				
										
			if($usernameCheck->profile_picture){
				$profile_picture=$usernameCheck->profile_picture;
				}
			else{
				 $profile_picture="profile.jpg";	
				}	

				$profile_picture="img/users/".$profile_picture;
				
				if(!file_exists($profile_picture)){
					$profile_picture ="img/users/profile.jpg";
					}
				
					//call view				
					return View::make('user')
								 ->with('pageName',$page2)
								 ->with('username',$username)
								 ->with('content',$getData)
								 ->with('profilePicLarge',$profile_picture)
								 ->with('first_name',$usernameCheck->first_name)
								 ->with('last_name',$usernameCheck->last_name)
								 ->with('created_at',$usernameCheck->created_at)
								 ->with('oneliner_count',$this->getPostCount($usernameCheck->id,'1'))
								 ->with('hoot_count',$this->getPostCount($usernameCheck->id,'2'))
								 ->with('short_story_count',$this->getPostCount($usernameCheck->id,'3'))
								 ->with('story_count',$this->getPostCount($usernameCheck->id,'4'))
								 ->with('article_count',$this->getPostCount($usernameCheck->id,'5'))
								 ->with('userSession',Auth::user());
					}
				else{		
						if(Auth::user()){
								if(Helpers::checkUser(Auth::user()->email)->username){
									
									if(Helpers::getByUsername(Auth::user()->username) && Helpers::followCountById(Auth::user()->id)>=3){
										
										return Redirect::to(Auth::user()->username);
										}
									else{	
										return Redirect::to('get-started');
										}
									}
								else{
										return Redirect::to('get-started');
									}
							}else{
										return View::make('login');
							}
					}
	}
	
	
	public function getTypeValue($page){
			$getData=Type::where('name',$page)->first();
			return $getData->id;
		}
		
	public function checkType($page){
		$getData=Type::where('name',$page)->first();
		if($getData){
			return $page;
			}
		else{
			return "one-liner";
			}
		}
		
	public function create(){
	//	$post =preg_replace('/\s+/', ' ',trim(Input::get('post')));
	$post =Input::get('post');
		$typeId=$this->checkPostType($post);
		
		$content_check=$this->checkWordsInDB($post,$typeId);
		if($content_check){
			Helpers::deleteOldPublished($content_check->id,Auth::user()->id);			
			Published::create(array(
									'post_id'=>$content_check->id,
									'user_id'=>Auth::user()->id,
									'type_id'=>$content_check->type_id,
									'repost'=>'1'
									));
				Input::flashOnly('post');
				return Redirect::to($this->getNameById($typeId));
			}
		else{
				if($typeId){
					$getInfo= Post::create(array('post' =>$post,
								'user_id'=>Auth::user()->id,
								'type_id'=>$typeId));					
					if($getInfo){
						Published::create(array(
									'post_id'=>$getInfo->id,
									'user_id'=>$getInfo->user_id,
									'type_id'=>$typeId));
						}
					return Redirect::to($this->getNameById($typeId));				
					}
				else{
					Input::flashOnly('post');
					Session::flash('post', '0');
					return Redirect::to(Auth::user()->username."/compose");
					}
			}	
		}
		
		
	public function checkPostType($post){
		
			$chek_post_length=strlen(trim($post));
			if($chek_post_length>=48 && $chek_post_length<=180){
					return $this->getTypeIdByName('hoot');
				 }
			elseif($chek_post_length>=181 && $chek_post_length<=512){
					return $this->getTypeIdByName('poetry');
				 }
			elseif($chek_post_length>=513 && $chek_post_length<=1024){
					return $this->getTypeIdByName('story');
				 }
			elseif($chek_post_length>=1025){
				return $this->getTypeIdByName('article');
				 }
			else{
				 return null;
				}
			}
			
			
	public function getTypeIdByName($name){
		
		$getData=Type::where('name',$name)->first();
		return $getData->id;
		}
		
		
	public function getNameById($id){
			if($id){
				$getData=Type::where('id',$id)->first();
				return $getData->name;
				}
			else{
				return "one-liner";
				}	
		}
	
	public function checkUserName($username){
		$getData=User::where('username',$username)
					 ->first();
		 return $getData;
	 }	
	 
	 public function getProfilePic($uid){
			 $getData=User::where('id',$uid)
						 ->first();
			 return $getData;
		 }
	
	public function getPostCount($uid,$typeId){
		
		return $getCount=Post::where('user_id',$uid)
						->where('type_id',$typeId)
					 ->count();
		
		}
		
	public function getTimeline($type,$userId){
		
			return $getData=	DB::table('published')		
									->Where('user_id',$userId)									
									->orwhereIn('user_id',function($query) use ($userId)
									{
										$query->select('follow_uid')
											  ->from('followers')
											  ->whereRaw('followers.user_id = "'.$userId.'"');
											 
									})->orderBy('id','desc')
									->get();
		}
		
			
		
  public function checkWordsInDB($post,$type_id){
	  
	  return $post=  DB::table('post')->where(function($query) use ($type_id,$post) {
                            $query->where('type_id',$type_id)
								  ->where('post', 'LIKE', '%' . $post .'%');
                                   
                        })->first();
	 }		
	
		
	
  public function update(){
	if(Auth::user()){
			
			$checkUpdate=Input::get('update_user');
			
			if($checkUpdate=='userinfo')
				{
					$rules = array(
						'first_name' => 'required|min:3|max:30'
						);
					$v = Validator::make( Input::all(), $rules );
					if( $v->fails())
						{
							return Redirect::to(Auth::user()->username.'/settings')->withErrors($v);
						}
					else{	
						
						$updateData=array('first_name'=>Input::get('first_name'),
										  'last_name'=>Input::get('last_name')
											);
							Helpers::updateUserInfo($updateData);
							Session::flash('notification', '1');
							Return Redirect::to(Auth::user()->username."/settings");
						}
				}
			elseif($checkUpdate=='user_post'){
						$rules = array(
							'about_me' => 'required|min:50|max:2000'
							);
						$v = Validator::make( Input::all(), $rules );
						if( $v->fails())
							{
								return Redirect::to(Auth::user()->username.'/settings')->withErrors($v);
							}
						else{	
							$updateData=array('about'=>Input::get('about_me'));
								Helpers::updateUserInfo($updateData);
								Session::flash('notification', '1');
								Return Redirect::to(Auth::user()->username."/settings");
							}
				}	
			
			elseif($checkUpdate=='pass_update'){
					
					if (Hash::check(Input::get('password_old'),Helpers::getUserInfo(Auth::user()->id)->password)){
							$rules = array(
							 'password_new' => 'required|min:5'
							);
						$v = Validator::make( Input::all(), $rules );
							if( $v->fails())
								{
									return Redirect::to(Auth::user()->username.'/settings')->withErrors($v);
								}
							else{	
									$updateData=array('password'=>Hash::make(Input::get('password_new')));
									Helpers::updateUserInfo($updateData);
									Session::flash('notification', '1');
									Return Redirect::to(Auth::user()->username."/settings");
								}
						}
					else{
						 Session::flash('notification', '2');
						 Return Redirect::to(Auth::user()->username."/settings");
						}
				}
				
			elseif($checkUpdate=='image'){	
				
				$rules = array(
							'profile_picture' => 'mimes:jpeg,bmp,png'
							);
						$v = Validator::make( Input::all(), $rules );
						if( $v->fails())
							{
								return Redirect::to(Auth::user()->username.'/settings')->withErrors($v);
							}
						else{	
							
							$getname=Input::file('profile_picture')
										->move("img/users",Auth::user()->id.Input::get('profile_picture').".".Input::file('profile_picture')
										->getClientOriginalExtension());
							//crop picture	
							 Image::make("img/users/".Auth::user()->id.".".Input::file('profile_picture')->getClientOriginalExtension())->resize(20, 20)
								->save("img/profile_25/".Auth::user()->id.".jpg");
							 Image::make("img/users/".Auth::user()->id.".".Input::file('profile_picture')->getClientOriginalExtension())->resize(260, 290)
								->save("img/users/".Auth::user()->id.".jpg");
								//update in data base
								$updateData=array('profile_picture'=>Auth::user()->id.".jpg");
								Helpers::updateUserInfo($updateData);
								Session::flash('notification', '1');
								Return Redirect::to(Auth::user()->username."/settings");	
							}
					}
				}
			else{
					Return Redirect::to(URL::to('/'));
				}		
			}
			
 	public function delete($username,$id){
		$getInfo=Helpers::getPublishedPostInfo($id);
		if(Auth::user()){
			if($getInfo->repost){
				//delete from repost
					DB::table('published')->where('id', '=',$id)						
							->delete();
				}
			else{
				//delete if author 				
					if(Helpers::checkPostUser($getInfo->post_id,Auth::user()->id)){
						
						DB::table('post')->where('id', '=',$getInfo->post_id)
											->where('user_id','=',Auth::user()->id)							
										->delete();
						DB::table('published')->where('post_id', '=',$getInfo->post_id)						
										->delete();
						}
				}	
				return Redirect::to(URL::to($username));
			}
		else{
			 return Redirect::to(URL::to('/'));
			}
		}
		
	public function getUserPost($type,$userId){
						return $getData=	DB::table('published')
									->where('type_id',$type)
									->where('user_id',$userId)
									->whereExists(function($query)
									{
											  $query->select(DB::raw(1))
											  ->from('post')
											  ->whereRaw('post.user_id = published.user_id');
											 
									})
									->get();
		}
}
