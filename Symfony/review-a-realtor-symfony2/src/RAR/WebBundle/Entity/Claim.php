<?php
namespace RAR\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_claim")
 */
class Claim
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
    public $claimed_by;
        /**
     * @ORM\Column(type="string")
     */
    public $current_owner;
         /**
     * @ORM\Column(type="integer")
     */
    public $property_id;
            /**
     * @ORM\Column(type="integer")
     */
    public $status;
          /**
     * @ORM\Column(type="string")
     */
    public $type;
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
     * Set claimed_by
     *
     * @param string $claimedBy
     * @return Claim
     */
    public function setClaimedBy($claimedBy)
    {
        $this->claimed_by = $claimedBy;
    
        return $this;
    }

    /**
     * Get claimed_by
     *
     * @return string 
     */
    public function getClaimedBy()
    {
        return $this->claimed_by;
    }

    /**
     * Set current_owner
     *
     * @param string $currentOwner
     * @return Claim
     */
    public function setCurrentOwner($currentOwner)
    {
        $this->current_owner = $currentOwner;
    
        return $this;
    }

    /**
     * Get current_owner
     *
     * @return string 
     */
    public function getCurrentOwner()
    {
        return $this->current_owner;
    }

    /**
     * Set property_id
     *
     * @param integer $propertyId
     * @return Claim
     */
    public function setPropertyId($propertyId)
    {
        $this->property_id = $propertyId;
    
        return $this;
    }

    /**
     * Get property_id
     *
     * @return integer 
     */
    public function getPropertyId()
    {
        return $this->property_id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Claim
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Claim
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
}