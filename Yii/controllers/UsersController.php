<?php

class UsersController extends Controller
{

	public $layout='home';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('home','customise','customiseconfirm','confirmsuccess','create','register','saveFront','claim','success','failure','fbshare','confirm','checkWords','terms','support', 'legalnotice','checkUniqueCode'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('home','customise','customiseconfirm','confirmsuccess','create','register','saveFront','claim','success','failure','fbshare','confirm','checkWords','terms','support', 'legalnotice','checkUniqueCode'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function loadModel($id)
	{
			$model=Users::model()->findByPk($id);
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
			if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	}
	public function actionHome()
	{
			$this->layout ="home";
			$this->render('home');

	}

	public function actionRegister()
	{
			$this->layout ="homeinner";
			$model=new Users;

			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);

			if(isset($_POST['Users']))
			{ 
				$this->performAjaxValidation($model);
				$model->attributes=$_POST['Users'];
				//Set the static values for creation and modification timestamp
				$model->country = $_POST['country'];
				$model->date_created = date('Y-m-d H:i:s');
				$model->date_modified = date('Y-m-d H:i:s');
				$model->unique_code = mt_rand(100000, 999999);
				$model->status = "Registered";
				if(!$_POST['Users']['region'])
				{
					$model->region = $_POST['region1'];
					$_SESSION['region'] =$_POST['region1'];
				}

			   //storing values in session
			   $_SESSION['userRegisterVal'] = $_POST['Users'];
			   $_SESSION['country'] = $_POST['country'];
			   $_SESSION['date_created'] = date('Y-m-d H:i:s');
			   $_SESSION['date_modified'] =date('Y-m-d H:i:s');
			   $_SESSION['unique_code'] = mt_rand(100000, 999999);
			   $_SESSION['status'] = "Registered";

			   
			   if($model->validate())
			   	$this->redirect('customise');
			}
			$this->render('create',array(
				'model'=>$model,
			));
	}


	protected function performAjaxValidationGift($model)
	{
			if(isset($_POST['ajax']) && $_POST['ajax']==='gift-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	}

	public function actionCustomise()
	{
		
		//Check for user action (if the user has already filled in his details or not)
		if(isset($_SESSION) && isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal']['email'] != '')
		{
			$this->layout ="homeinner";
			$model=new Gift;
			
			//Begin - Get dataurl for image and saving it to directory ....
			 if(isset($_POST['src']))
			 {
				// Get the image data
				$imageData=$_POST['src'];
				$_SESSION['imagesrc'] =  $imageData;
				
			 } 
			 else 
			 {
				 $_SESSION['anotherimagesrc'] =  "no image";
			 }
            //End - Get dataurl for image and saving it to directory ....

			//Post data to gift model
			if(isset($_POST['Gift']))
			{
				$model->attributes=$_POST['Gift'];
				$model->size = $_POST['size'];
				//$model->jersey_mockup = $_SESSION['jersey_mockup'];
				$model->created = date('Y-m-d H:i:s');
				$model->modified = date('Y-m-d H:i:s');
				$model->status = "PENDING";

				// Storing value for gift in session
				$_SESSION['userCustomizeVal'] = $_POST['Gift'];
				$_SESSION['size'] = $_POST['size'];
				$_SESSION['statusGift'] = "PENDING";
							
				
							
			    $this->redirect(array('customiseconfirm'));
			}

			$this->render('customizejersey',array(
			 'model'=>$model,
			));
		}
		else
		{
			$this->redirect('index.php', '');
		}
	}

	public function actionCustomiseconfirm()
	{
		//Check for user action (if the user has already filled in his details or not)
		if(isset($_SESSION) && isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal']['email'] != '')
		{
			$this->layout ="homeinner";
			$modelUser=new Users;
			$modelGifts=new Gift;

			//simply redirecting to Confirm page...
			$this->render('customizejerseyconfirm',array(
				'modelUser'=>$modelUser,
			));
		
		}
		else
		{
			//Redirect to home page
			$this->redirect('../index.php', '');
		}
	}

	public function actionConfirmsuccess()
	{
		//Check for user action (if the user has already filled in his details or not)
		if(isset($_SESSION) && isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal']['email'] != '')
		{
			   $this->layout ="homeinner";
			   $modelUser=new Users;
			   $modelGifts=new Gift;
					
			   // for saving model users data through session value....
			   $modelUser->first_name =$_SESSION['userRegisterVal']['first_name'];
			   $modelUser->last_name =$_SESSION['userRegisterVal']['last_name'];
			   $modelUser->email =$_SESSION['userRegisterVal']['email'];
			   $modelUser->address1 =$_SESSION['userRegisterVal']['address1'];
			   $modelUser->suburb =$_SESSION['userRegisterVal']['suburb'];
			   $modelUser->country =$_SESSION['country'];
	
			   if(($_SESSION['userRegisterVal']['region']) && $_SESSION['userRegisterVal']['region'] != "")
			   {
			      $modelUser->region = $_SESSION['userRegisterVal']['region'];
		       } 
		       else 
		       {
		          $modelUser->region = $_SESSION['region'];
		       }
		      
			   $modelUser->postcode =$_SESSION['userRegisterVal']['postcode'];
			   $modelUser->unique_code =$_SESSION['unique_code'];
			   $modelUser->date_created =$_SESSION['date_created'];
			   $modelUser->date_modified =$_SESSION['date_modified'];
			   $modelUser->status =$_SESSION['status'];
			   $modelUser->save();
			    // for saving model users data ends here....
	           
			    //for getting lastInserted ID of User model....
	           $max= Yii::app()->db->getLastInsertId();
	           
	           // for saving model "Gift" data....
			   $modelGifts->user_id =$modelUser->id;
			   $modelGifts->size =$_SESSION['size'];
			   $modelGifts->custom_msg =$_SESSION['userCustomizeVal']['custom_msg'];
			   $modelGifts->created =$_SESSION['date_created'];
			   $modelGifts->modified =$_SESSION['date_modified'];
	
			   if(isset($_SESSION['imagesrc']) && $_SESSION['imagesrc'] != "")
			   {
				   $img_info   = getimagesize($_SESSION['imagesrc']);
				   // print_r($img_info);  die();
				   if($img_info['mime'] == 'image/png')
				   {
				   //for saving image into directory
				    $content = file_get_contents($_SESSION['imagesrc']);
					$name = md5($_SESSION['userRegisterVal']['first_name'].$_SESSION['userRegisterVal']['last_name']).time().'.png';
					$imagename = $name;
					file_put_contents('tshirt/'.$imagename, $content);
					
					
					$_SESSION['jersey_mockup'] = $imagename;
				    //for saving image into directory
				    } 
				    else 
				    {
						unlink('tshirt/'.$imagename);  
					}
			   } 
			   else
			   {
			  		$_SESSION['jersey_mockup'] =  $_SESSION['anotherimagesrc'] ;
			   }

		   	   $modelGifts->jersey_mockup = $_SESSION['jersey_mockup'];

		   	   $modelGifts->status =$_SESSION['statusGift'];
		  	   $modelGifts->shared =0;

		  /*if data in both Model will be saved......*/
           // for saving data through transaction process
			$transaction =  Yii::app()->db->beginTransaction();
			try {
				if (!$modelUser->save()) {
						$transaction->rollback();
						return false;
				}
				
				if (!$modelGifts->save()) {
						$transaction->rollback();
						return false;
				}
				
				$transaction->commit();
			
				  Yii::app()->user->setFlash('successmessage','You are registered properly');
				   
				  	$_SESSION['giftId'] = $modelGifts->id;
					$userEmail = $modelUser->email;
					$userFname = $modelUser->first_name;
	
				    //for sending email to users registered
				    $message     = new YiiMailMessage;
					
				    //this points to the file thanks.php inside the view path
					$message->view 		 = "thanks";
					$params              = array('name'=>$userFname);
					$message->subject    = 'Thanks for registering for your customised EA SPORTS Football Club Jersey';
					$message->setBody($params, 'text/html');
					$message->addTo($userEmail);
					$message->from = 'noreply@fifa14fanatics.com.au';
					Yii::app()->mail->send($message);
				   
					//for sending email to users registered ends here
					$this->redirect(array('confirm'));
			  
		    
					//for sending values to fbshare page
					$userGiftId=  $modelGifts->id;
					
					// for sending values to fbshare page	
					$giftLastValue=Gift::model()->findByAttributes(array('id'=>$userGiftId));
				    // for sending values to fbshare page
					
					
					$this->render('finalconfirmed',array(
				   'modelUser'=>$modelUser,
				   'maxIdGift'=>$userGiftId,
				   'giftLastValue'=>$giftLastValue,

				   ));
				   
				   } 
				   catch (Exception $ex)
				   {
					$transaction->rollback();
					return false;
					Yii::app()->user->setFlash('failmessage','Please fill the form properly again');
				   }
	
	}
    else
    {
		//Redirect to home page
		$this->redirect('../index.php', '');
    }

	
}
	public function actionConfirm()
	{
		//Check for user action (if the user has already filled in his details or not)
		if(isset($_SESSION) && isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal']['email'] != '')
		{
			  $this->layout ="homeinner";
			  $modelUser=new Users;
			  
			  //for getting lastly saved value of Gift model
			 $userGiftId = $_SESSION['giftId'];
			 
			  if(isset($userGiftId) && $userGiftId != '')
			  {
				 
				  Yii::app()->user->setFlash('successmessage','You have been registered properly.. Please check your mailbox');
			  }
			  else 
			  {
				 
				  Yii::app()->user->setFlash('failuremessage','Please fill the form properly again');
			  }
			  //for getting lastly saved value of Gift model by current user
		      $giftLastValue=Gift::model()->findByAttributes(array('id'=>$userGiftId));
			  //for getting lastly saved value of Gift model by current user
			
			  //destroying session here..
	          session_destroy(); 
	          
	          //create new session to keep current gift id for fbshare
	          session_start();
	          $_SESSION['giftId'] = $userGiftId;
	
	          //render page to view page....
			  $this->render('finalconfirmed',array(
				 'modelUser'=>$modelUser,
				 'maxIdGift'=>$userGiftId,
				 'giftLastValue'=>$giftLastValue,
			 ));
		}
		else
		{
		  	//Redirect to home page
			$this->redirect('../index.php', '');
		}
	}

	public function actionFbshare()
    {
		 $this->layout ="test";
    	//Check for user action (if the user has already filled in his details or not)
		if(isset($_SESSION) && isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal']['email'] != '')
		{
		    	if(is_numeric($_POST['id'])) 
				{ 
					$giftId=  $_POST['id'];
					/*for counting number of fbcounts....*/
					 $updateCodes = Yii::app()->db->createCommand()
									->update('gift', array('shared'=>'shared' + 1),
									'user_id=:user_id',array(':user_id'=>$giftId));
					echo CJavaScript::jsonEncode('true');
					Yii::app()->end();
		
				} 
				else 
				{
					echo CJavaScript::jsonEncode('false');
					Yii::app()->end();
				}
    	}
		else
		{
			//Redirect to home page
			$this->redirect('../index.php', '');
		}
    }

    public function actionClaim()
    {
		$this->layout ="home";
		$model=new Users;
		
		//Check if user has entered the email id or not
		if(isset($_POST['email']))
		{
			$_SESSION['claimEmailVal'] = $_POST['email'];
			$_SESSION['claimUniqueCodeVal'] = $_POST['unique_code'];

			$user = Users::model()->findByAttributes(array('email' => $_POST['email']));
			$codeVal = Codes::model()->findByAttributes(array('uniquecode' => $_POST['unique_code']));
			if (!$user)
			{
				Yii::app()->user->setFlash('email','Please enter a registered email address');
			}
			else
			{
                if(!$codeVal)
				{
				  Yii::app()->user->setFlash('failmessage','Please try your unique code again');
				}

				elseif($codeVal->status == 0)
				{
						//updating Codes table for status and other values
						$updateCodes = Yii::app()->db->createCommand()
									->update('codes', array('status'=>1,'date_claimed'=>date('Y-m-d H:i:s'),'claimed_by'=>$user['id']),
									'uniquecode=:uniquecode',array(':uniquecode'=>$codeVal->uniquecode));
					 
						//updating User table for status
						$updateUsers = Yii::app()->db->createCommand()
									->update('users', array('status'=>'Claimed'),
									'id=:id',array(':id'=>$user->id));
					
						//for sending email to users who successfully claims
						$userFname   = $user->first_name;
						$userEmail   = $user->email;
						
						$message     = new YiiMailMessage;
						
						//this points to the file claim.php inside the view path
						$message->view 		 = "claim";
						$params              = array('name'=>$userFname);
						$message->subject    = 'Congratulations';
						$message->setBody($params, 'text/html');
						$message->addTo($userEmail);
						$message->from = 'noreply@fifa14fanatics.com.au';
						Yii::app()->mail->send($message);
				   
						//for sending email to users who successfully claims ends here


						 session_destroy();
						 session_start();
						 $_SESSION['claimed'] = 'success';
						 $this->redirect(array('success'));
						 //$this->redirect(array('failure'));
				}
                elseif($codeVal->status == 1)
				{
						session_destroy();
						session_start();
						$_SESSION['claimed'] = 'failure';
						$this->redirect(array('failure'));
				}
              	else
				{
						$this->redirect(array('success'));
				}
			}
		}
		$this->render('claim',array(
			'model'=>$model,

		));
	}

	public function actionSuccess()
	{
		if(isset($_SESSION) && isset($_SESSION['claimed']) && $_SESSION['claimed']=='success')
			$this->render('success');
		else
			$this->redirect('../index.php', '');
    }


	public function actionFailure()
	{
		if(isset($_SESSION) && isset($_SESSION['claimed']) && $_SESSION['claimed']=='failure')
			$this->render('failure');
		else
			$this->redirect('../index.php', '');
    }

	public function actionCheckWords()
    {
			
		// for getting value of badwords model
		$strWords =  $_GET['q'];
		$queryResulqt='SELECT words FROM badwords';
		$wordsValue1 =Yii::app()->db->createCommand($queryResulqt)->queryAll();
		
		foreach($wordsValue1 as $value)
		{
			$words[] = trim($value['words']);

		}
		
		if(in_array(trim($strWords), $words))
		{
			echo 0;
		}
		else
		{
			echo 1;
		}
	 }



	 public function actionTerms()
	 {
		 $this->layout ="homelinks";
		 $this->render('terms',array(''));
	 }

	 public function actionSupport()
	 {
		 $this->layout ="homelinks";
		 $this->render('support',array(''));
	 }

	 public function actionLegalNotice()
	 {
		 $this->layout ="homelinks";
		 $this->render('legalnotice',array(''));
	 }

}
