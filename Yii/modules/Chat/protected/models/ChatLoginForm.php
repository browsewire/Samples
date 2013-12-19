<?php

/**
 * ChatLoginForm class.
 * ChatLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SimpleChat'.
 */
class ChatLoginForm extends CFormModel
{
	public $username;
	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username', 'required'),
			// rememberMe needs to be a boolean
			
		);
	}

	

	

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		$session=new CHttpSession;
		$session->open();
		$session['chatuser']=$this->username;
		$fp = fopen("log.html", 'a');  
    fwrite($fp, "<div class='msgln'><i>User ". $session['chatuser'] ." has join the chat session.</i><br></div>");  
    fclose($fp); 
		return true;
		
	}
}
