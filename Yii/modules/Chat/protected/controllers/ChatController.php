<?php

class ChatController extends Controller
{
	
	
	 public function actionIndex()
	{
		$model=new ChatForm;
		$session=new CHttpSession;
		$session->open();
		if(!$session['chatuser']){
    $this->redirect(Yii::app()->createUrl('chat/login'));
    }else{
   	$this->render('index',array('model'=>$model,'chatuser'=>$session['chatuser']));
		}
	}
	
	/**
	 * Displays the chat login
	 */
	public function actionLogin()
	{
	  
		$model=new ChatLoginForm;
    // collect user input data
		if(isset($_POST['ChatLoginForm']))
		{
			$model->attributes=$_POST['ChatLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->login())
				$this->redirect(Yii::app()->createUrl('chat/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout()
	{
	  
    $session=new CHttpSession;
		$session->open();
		$fp = fopen("log.html", 'a');  
    fwrite($fp, "<div class='msgln'><i>User ". $session['chatuser'] ." has left the chat session.</i><br></div>");  
    fclose($fp); 
		unset($_SESSION['chatuser']);
		
		$this->redirect(Yii::app()->createUrl('chat/login'));
	}
	
	
	public function actionPost()
	{
	  $session=new CHttpSession;
		$session->open();
		$text = $_POST['text'];  
      
    $fp = fopen("log.html", 'a');  
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$session['chatuser']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");  
    fclose($fp);
    
	}
}