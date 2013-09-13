<?php

class AdminController extends Controller
{
		/**
		 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
		 * using two-column layout. See 'protected/views/layouts/column2.php'.
		 */
		public $layout='//layouts/column2';
	
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
					'actions'=>array('index','view','logout'),
					'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
					'actions'=>array('create','update','dashboard','editUser','usersLanding','userSearch','userList','export','getEmail', 'searchEmail','exportTable','bulkEmail','updateNotify'),
					'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
					'actions'=>array('admin','delete','dashboard','logout','editUser','usersLanding','userSearch','userList','export','getEmail', 'searchEmail','exportTable','bulkEmail','updateNotify'),
					'users'=>array('admin'),
				),
				array('deny',  // deny all users
					'users'=>array('*'),
				),
			);
		}
		
		/**
		 * Lists all models.
		 */
		public function actionIndex()
		{
			$this->layout ="backend";
			$model=new LoginForm;
	
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(array('admin/dashboard'));
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
	
		
		/**
		 * Returns the data model based on the primary key given in the GET variable.
		 * If the data model is not found, an HTTP exception will be raised.
		 * @param integer the ID of the model to be loaded
		 */
		public function loadModel($id)
		{
			$model=Admin::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
		
		public function actionDashboard()
		{
			$this->layout ="admindashboard";
			$usersData=Users::model()->findAll();
		  
		    // for getting data groupby date
			$query='SELECT count(first_name) as m, date(date_created) as date, status, id
					FROM users
					GROUP BY date( date_created) DESC';
			$userRegDate=Yii::app()->db->createCommand($query)->queryAll();
					
			$statusReg= "Registered";
			$statusClaim= "Claimed";
			
			for($i=0;$i<count($userRegDate);$i++)
			{
				
					$queryReg="SELECT count(status) as registered from users where date(date_created)='".$userRegDate[$i]['date']."'
					 and status ='Registered'";
					$userReg=Yii::app()->db->createCommand($queryReg)->queryAll();
					
					$queryCla="SELECT count(status) as claimed from users where date(date_created)='".$userRegDate[$i]['date']."'
					 and status ='Claimed'";
					$userCla=Yii::app()->db->createCommand($queryCla)->queryAll();
					
					$queryRej="SELECT count(status) as rejected from users where date(date_created)='".$userRegDate[$i]['date']."'
					 and status ='Rejected'";
					$userRej=Yii::app()->db->createCommand($queryRej)->queryAll();
					
					$queryShared="SELECT sum(shared) as shared from gift where date(created)='".$userRegDate[$i]['date']."'";
					$userFbshared=Yii::app()->db->createCommand($queryShared)->queryAll();
					
					// for getting data for csv sheet 
					$queryCSVData="SELECT * from users where date(date_created)='".$userRegDate[$i]['date']."'";
					$csvData=Yii::app()->db->createCommand($queryCSVData)->queryAll();
				    
					if($userReg != "" || $userCla != "" || $userRej != "" || $userFbshared != "" ){
					$arrTemp = array("registered"=>$userReg[0]["registered"],"claimed"=>$userCla[0]["claimed"],"rejected"=>$userRej[0]["rejected"],"shared"=>$userFbshared[0]["shared"],"csvData"=>$csvData[0]);
					
					$userRegDate[$i]=array_merge($userRegDate[$i],$arrTemp);
					}
			}
			//echo "<pre>"; print_r($userRegDate);
					
			// for counting registrations
			$queryRegister='SELECT count(status) as m, status
			FROM users WHERE status ="Registered" || status ="Claimed"';
			$userRegistered=Yii::app()->db->createCommand($queryRegister)->queryAll();
			// for counting registrations
				
			// for counting Claimed
			$queryClaim='SELECT count(status) as m, status
			FROM users WHERE status ="Claimed" ';
			$userClaimed=Yii::app()->db->createCommand($queryClaim)->queryAll();
			// for counting Claimed
				
			// for counting Rejected
			$queryReject='SELECT count(status) as m, status
			FROM users WHERE status ="Rejected" ';
			$userRejected=Yii::app()->db->createCommand($queryReject)->queryAll();
			// for counting Rejected
				
			// for Facebook Shares
			$userFbShare = Yii::app()->db->createCommand()
	               			->select('sum(shared) as fbshare')
	                		->from('gift')
	                		->queryRow();
	              
			$this->render('dashboard',
				array(	
						'usersData'=>$usersData,
						'userRegDate'=>$userRegDate,
						'userRegistered'=>$userRegistered,
						'userClaimed'=>$userClaimed,
						'userRejected'=>$userRejected, 
						'userFbShare'=>$userFbShare,
				)
			);
		}
		
		
		public function loadModelUser($id)
		{
			$model=Users::model()->findByPk($id);
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			return $model;
		}
		
		
		public function actionEditUser($id) 
		{
		   	$this->layout ="admindashboard";
			
			//for editing users starts here
			$model=$this->loadModelUser($id);
			
			//for getting values from gift model
			$Gift=Gift::model()->findByAttributes(array('user_id'=>$model->id,));
		    // for getting values from gift model
			
			//Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
	
			if(isset($_POST['Users']))
			{
				$model->attributes=$_POST['Users'];
				$model->status = $_POST['status'];
				$Gift->custom_msg = $_POST['custom_msg'];
				$model->date_modified = date('Y-m-d H:i:s');
				if($model->save())
				{
					$Gift->save();
				   	$this->redirect(array('userList'));
				}
			}
	
			$this->render('edituser',array(
				'model'=>$model,
				'Gift'=>$Gift,
				
			));
			
			//for editing users ends here
			
		}
		
		public function actionUsersLanding()
		{
			$this->layout ="admindashboard";
			$this->render('userslanding');
		}
		
		public function actionUserSearch()
		{
		   $this->layout ="admindashboard";
		   $this->render('usersearch');
		}
		
		public function actionUserList()
		{
			$this->layout ="admindashboard";
			   
			if(isset($_POST['inputDAtes']))
			{
					$as = $_POST['inputDAtes'];
					$asdate = date("Y-m-d",strtotime($as));
					$queryUser="SELECT users.*,gift.custom_msg from users LEFT JOIN gift ON users.id=gift.user_id where date_created like '".$asdate."%'";
					//$queryUser="SELECT * from users where date_created like '".$asdate."%'";
					$userData=Yii::app()->db->createCommand($queryUser)->queryAll();
				
			} 
			else 
			{
					$a =date("d F Y");
					$asdate = date("Y-m-d",strtotime($a));
					$queryUser="SELECT users.*,gift.custom_msg from users LEFT JOIN gift ON users.id=gift.user_id where date_created like '".$asdate."%'";
					$userData=Yii::app()->db->createCommand($queryUser)->queryAll();
			}
			$this->render('userlist',
			array('userData'=>$userData));
		}
		
		
		// for getting email id through jquery in view page of searchuser in admin
		
		function actionSearchEmail()
		{
			$queryGetEmail ='SELECT * FROM users WHERE email LIKE "'.$_REQUEST['term'].'%"';
			$getEmail = Yii::app()->db->createCommand($queryGetEmail)->queryAll();
			
			foreach($getEmail as $get)
			{
				$data[]=$get['email'];
		    }
			echo json_encode($data);
			// for searching email
			
	    }
	
	
	    //for getting email id through jquery in view page
	    function actionGetEmail() 
	    {
			   $this->layout ="admindashboard";
			   if(isset($_POST['email'])){
		       $email =  $_POST['email'];
		       $querysearchData="SELECT users.*,gift.custom_msg from users LEFT JOIN gift ON users.id=gift.user_id where email='".$email."'";
		       $userData=Yii::app()->db->createCommand($querysearchData)->queryAll();
		       $this->render('usersearched',
			   array('userData'=>$userData));
		   }
		   else 
	       {
			    $this->render('usersearch');
		   }
	    }
	   
	   
		
		//for exporting data to csv sheet..
		function actionExport()
		{ 
				$FileName = "FIFA14_".date("Ymd_h:i:s") . '.csv';
				$Content = "";
	
				# Titlte of the CSV
				$Content = "id,first_name,last_name,email,address1,suburb,country,region,postcode,unique_code,status,date_created,date_modified \n";
	
				# fill data in the CSV
				$as = $_POST['dateDAta'];
			    $asdate = date("Y-m-d",strtotime($as)); // for getting date in year-month-day format
				$querysearchData="SELECT * from users where date_created like '".$asdate."%'"; 
				$userData=Yii::app()->db->createCommand($querysearchData)->queryAll();
				foreach($userData as $row)
				{
	                $columns = ""
	                .$row['id'].","
	                .$row['first_name'].","
	                .$row['last_name'].","
	                .$row['email'].","
	                .$row['address1'].","
	                .$row['suburb'].","
	                .$row['country'].","
	                .$row['region'].","
	                .$row['postcode'].","
	                .$row['unique_code'].","
	                .$row['status'].","
	                .$row['date_created'].","
	                .$row['date_modified']."";
	             
	           		$Content .= $columns."\n";
				}
	
				header('Content-Disposition: attachment; filename="' . $FileName . '"');
				echo $Content;
				exit(); 
	    }
	    
	    public function actionBulkEmail()
		{
			$this->layout ="admindashboard";
			
			$usernotNotified = Yii::app()->db->createCommand()
						->select('COUNT(id) as notify')
						->from('users')
						->where('notified= 0 and status = "Registered"') 
						->queryAll(); 
			
			$this->render('sendEmail',array('usernotNotified'=>$usernotNotified));
		}
		
		public function actionUpdateNotify()
		{
			$this->layout ="admindashboard";
			
			$usernotNotified = Yii::app()->db->createCommand()
						->select('*')
						->from('users')
						->where(array('notified= 0 and status = "Registered"')) 
						->queryAll(); 
			
			//print_r($usernotNotified);
			if($usernotNotified)
			{
				foreach($usernotNotified as $usernotNotified)
				{ 
						$updateUsers = Yii::app()->db->createCommand()
								  ->update('users', array('notified'=>1),
								  'id=:id',array(':id'=>$usernotNotified['id']));
								  
						//for sending email to users who are not notified yet
						$userFname   = $usernotNotified['first_name'];
						$userEmail   = $usernotNotified['email'];
						
						$message     = new YiiMailMessage;
						
						//this points to the file notification.php inside the view path
						$message->view 		 = "notification";
						$params              = array('name'=>$userFname);
						$message->subject    = 'Reminder';
						$message->setBody($params, 'text/html');
						$message->addTo($userEmail);
						$message->from = 'noreply@fifa14fanatics.com.au';
						Yii::app()->mail->send($message);
				   
						//for sending email to users who are not notified yet
							  
			   }
		}
			
			
		}
}
