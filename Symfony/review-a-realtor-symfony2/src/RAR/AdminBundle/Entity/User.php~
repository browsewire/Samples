<?php
namespace RAR\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $first_name;

    /**
     * @ORM\Column(type="string")
     */
    public $last_name;

    /**
     * @ORM\Column(type="string")
     */
    public $email;

    /**
     * @ORM\Column(type="string")
     */
    public $password;

    /**
     * @ORM\Column(type="string")
     */
    public $phone;
    
        /**
     * @ORM\Column(type="string")
     */
    public $address;
    
          /**
     * @ORM\Column(type="string")
     */
     public $address2;
    
          /**
     * @ORM\Column(type="string")
     */
    public $city;
          /**
     * @ORM\Column(type="string")
     */
    public $facebook_id;

      /**
     * @ORM\Column(type="string")
     */
    public $state;
          /**
     * @ORM\Column(type="string")
     */
 
    public $business_name;
             /**
     * @ORM\Column(type="integer")
     */
    public $subscription_type_id;
             /**
     * @ORM\Column(type="string")
     */
    public $country;
    
          /**
     * @ORM\Column(type="string")
     */
     
    public $pincode;
             
              /**
     * @ORM\Column(type="string")
     */
     
    public $logo;
              /**
     * @ORM\Column(type="string")
     */
     
    public $fax;
              /**
     * @ORM\Column(type="string")
     */
     
    public $overview;
                  /**
     * @ORM\Column(type="string")
     */
     
    public $twitter;
                  /**
     * @ORM\Column(type="string")
     */
     
    public $google;
                 
                  /**
     * @ORM\Column(type="string")
     */
     
    public $linkedin;
                     
                  /**
     * @ORM\Column(type="string")
     */
     
    public $facebook;
              /**
     * @ORM\Column(type="string")
     */
        
    public $video;
    
              /**
     * @ORM\Column(type="string")
     */
     
    public $image;
    
          /**
     * @ORM\Column(type="integer")
     */
    public $creator_id;  
    
    /**
     * @ORM\Column(type="datetime")
     */
    public $creation_timestamp;
    
          /**
     * @ORM\Column(type="integer")
     */
    public $modifier_id;

    /**
     * @ORM\Column(type="datetime")
     */
    public $modification_timestamp;
         /**
     * @ORM\Column(type="integer")
     */
       public $type;
         /**
     * @ORM\Column(type="integer")
     */
      public $plan_id;
         /**
     * @ORM\Column(type="integer")
     */
      public $status;

	/**
     * @ORM\Column(type="string")
     */
      public $category1;

	/**
     * @ORM\Column(type="string")
     */
      public $category2;

	/**
     * @ORM\Column(type="string")
     */
      public $business_url;
          
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Users
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Users
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Users
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Users
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Users
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set pincode
     *
     * @param string $pincode
     * @return Users
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;
    
        return $this;
    }

    /**
     * Get pincode
     *
     * @return string 
     */
    public function getPincode()
    {
        return $this->pincode;
    }

    /**
     * Set creator_id
     *
     * @param integer $creatorId
     * @return Users
     */
    public function setCreatorId($creatorId)
    {
        $this->creator_id = $creatorId;
    
        return $this;
    }

    /**
     * Get creator_id
     *
     * @return integer 
     */
    public function getCreatorId()
    {
        return $this->creator_id;
    }

    /**
     * Set creation_timestamp
     *
     * @param \DateTime $creationTimestamp
     * @return Users
     */
    public function setCreationTimestamp($creationTimestamp)
    {
        $this->creation_timestamp = $creationTimestamp;
    
        return $this;
    }

    /**
     * Get creation_timestamp
     *
     * @return \DateTime 
     */
    public function getCreationTimestamp()
    {
        return $this->creation_timestamp;
    }

    /**
     * Set modifier_id
     *
     * @param integer $modifierId
     * @return Users
     */
    public function setModifierId($modifierId)
    {
        $this->modifier_id = $modifierId;
    
        return $this;
    }

    /**
     * Get modifier_id
     *
     * @return integer 
     */
    public function getModifierId()
    {
        return $this->modifier_id;
    }

    /**
     * Set modification_timestamp
     *
     * @param \DateTime $modificationTimestamp
     * @return Users
     */
    public function setModificationTimestamp($modificationTimestamp)
    {
        $this->modification_timestamp = $modificationTimestamp;
    
        return $this;
    }

    /**
     * Get modification_timestamp
     *
     * @return \DateTime 
     */
    public function getModificationTimestamp()
    {
        return $this->modification_timestamp;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return User
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    
        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set plan_id
     *
     * @param integer $planId
     * @return User
     */
    public function setPlanId($planId)
    {
        $this->plan_id = $planId;
    
        return $this;
    }

    /**
     * Get plan_id
     *
     * @return integer 
     */
    public function getPlanId()
    {
        return $this->plan_id;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    
    /**
     * Set business_name
     *
     * @param string $businessName
     * @return User
     */
    public function setBusinessName($businessName)
    {
        $this->business_name = $businessName;
    
        return $this;
    }

    /**
     * Get business_name
     *
     * @return string 
     */
    public function getBusinessName()
    {
        return $this->business_name;
    }

    /**
     * Set subscription_type_id
     *
     * @param integer $subscriptionTypeId
     * @return User
     */
    public function setSubscriptionTypeId($subscriptionTypeId)
    {
        $this->subscription_type_id = $subscriptionTypeId;
    
        return $this;
    }

    /**
     * Get subscription_type_id
     *
     * @return integer 
     */
    public function getSubscriptionTypeId()
    {
        return $this->subscription_type_id;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return User
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return User
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set overview
     *
     * @param string $overview
     * @return User
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;
    
        return $this;
    }

    /**
     * Get overview
     *
     * @return string 
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    
        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set google
     *
     * @param string $google
     * @return User
     */
    public function setGoogle($google)
    {
        $this->google = $google;
    
        return $this;
    }

    /**
     * Get google
     *
     * @return string 
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    
        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string 
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return User
     */
    public function setVideo($video)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    
        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

	/**
     * Set category1
     *
     * @param string $category1
     * @return User
     */
    public function setCategory1($category1)
    {
        $this->category1 = $category1;
    
        return $this;
    }

    /**
     * Get category1
     *
     * @return string 
     */
    public function getCategory1()
    {
        return $this->category1;
    }
	
	/**
     * Set category2
     *
     * @param string $category2
     * @return User
     */
    public function setCategory2($category2)
    {
        $this->category2 = $category2;
    
        return $this;
    }

    /**
     * Get category2
     *
     * @return string 
     */
    public function getCategory2()
    {
        return $this->category2;
    }

	/**
     * Set business_url
     *
     * @param string $businessUrl
     * @return User
     */
    public function setBusinessUrl($businessUrl)
    {
        $this->business_url = $businessUrl;
    
        return $this;
    }

    /**
     * Get business_url
     *
     * @return string 
     */
    public function getBusinessUrl()
    {
        return $this->business_url;
    }



    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;
    
        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }
}