<?php
namespace RAR\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_payment")
 */
class Payment
{
    
		/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $user_id;
                /**
     * @ORM\Column(type="integer")
     */
    public $recuring_period;
    
        /**
     * @ORM\Column(type="integer")
     */
    public $plan_id;
            /**
     * @ORM\Column(type="string")
     */
    public $transaction_id;
            /**
     * @ORM\Column(type="integer")
     */
    public $amount;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Payment
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set recuring_period
     *
     * @param integer $recuringPeriod
     * @return Payment
     */
    public function setRecuringPeriod($recuringPeriod)
    {
        $this->recuring_period = $recuringPeriod;
    
        return $this;
    }

    /**
     * Get recuring_period
     *
     * @return integer 
     */
    public function getRecuringPeriod()
    {
        return $this->recuring_period;
    }

    /**
     * Set plan_id
     *
     * @param string $planId
     * @return Payment
     */
    public function setPlanId($planId)
    {
        $this->plan_id = $planId;
    
        return $this;
    }

    /**
     * Get plan_id
     *
     * @return string 
     */
    public function getPlanId()
    {
        return $this->plan_id;
    }

    /**
     * Set creator_id
     *
     * @param integer $creatorId
     * @return Payment
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
     * @return Payment
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
     * @return Payment
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
     * @return Payment
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
     * Set transaction_id
     *
     * @param string $transactionId
     * @return Payment
     */
    public function setTransactionId($transactionId)
    {
        $this->transaction_id = $transactionId;
    
        return $this;
    }

    /**
     * Get transaction_id
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }
}