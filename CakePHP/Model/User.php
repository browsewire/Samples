<?php
class User extends AppModel
{
    public $hasMany = array(
        "UserGroupMembership",
        "Subscription",
        "EventNote",
    );
    
    public $validate = array(
        
    );
    
    public function beforeSave($options = array())
    {
        if(!empty($this->data[$this->alias]["password"]))
        {
            if(empty($this->data[$this->alias]["password_salt"]))
            {
                $this->data[$this->alias]["password_salt"] = sha1(microtime(true));
            }
            $this->data[$this->alias]["password"] = $this->hashPassword($this->data[$this->alias]["password"], $this->data[$this->name]["password_salt"]);
        } else {
            unset($this->data[$this->alias]["password"]);
        }
        parent::beforeSave($options);
    }
    
    public function beforeFind($query)
    {
        $this->virtualFields["first_name"] = "SUBSTRING_INDEX({$this->alias}.name,' ',1)";
        $this->virtualFields["last_name"] = "SUBSTRING_INDEX({$this->alias}.name,' ',-1)";
        parent::beforeFind($query);
    }
    
    public function hashPassword($password, $salt = "")
    {
        return sha1($password . Configure::read("Security.salt") . $salt);
    }
}