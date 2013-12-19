<?php

/**
 * ChatLoginForm class.
 * ChatLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SimpleChat'.
 */
class ChatForm extends CFormModel
{
	public $usermsg;
	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('usermsg', 'required'),
			// rememberMe needs to be a boolean
			
		);
	}

	

	

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function updatechat()
	{
		$session=new CHttpSession;
		$session['usermsg']='raman';
		return true;
		
	}
}
