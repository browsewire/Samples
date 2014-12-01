<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	
	public $timestamps = true;
   
    protected $fillable = array('email', 'first_name','username');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');
   
    private $rules = array(
         'first_name' => 'required|min:2',
         'email' => 'required|email|unique:users,email',
         'username' => 'required|unique:users,username',
         'password' => 'required|min:4',
    );

     
     private $errors;
     
	 public function validate($data){
		 
        $v = Validator::make($data, $this->rules);
        if($v->fails()) {
           
        $this->errors= $v->errors();
        
        return false;
        }
        return true;
       
    }
	 public function errors()
    {
        return $this->errors;
    }
     
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}
      
    public function getRememberToken()
		{
		    return $this->remember_token;
		}

    public function setRememberToken($value)
		{
		    $this->remember_token = $value;
		}

	public function getRememberTokenName()
		{
		    return 'remember_token';
		}
    
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	
	public function getgeo(){
		
		return $this->HasMany('Geoip','user_id');
		
	}
	
	public function getSubscriber(){
		return $this->HasMany('Subscriber','user_id');
	}
	
	
	

}
