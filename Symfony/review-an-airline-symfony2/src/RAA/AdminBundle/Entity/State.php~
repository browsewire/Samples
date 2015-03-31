<?php
namespace RAA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="raa_state")
 */
class State
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
    public $state_name;
 
 /**
     * @ORM\Column(type="string")
     */
    public $state_code;

    
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
     * Set state_name
     *
     * @param string $stateName
     * @return State
     */
    public function setStateName($stateName)
    {
        $this->state_name = $stateName;
    
        return $this;
    }

    /**
     * Get state_name
     *
     * @return string 
     */
    public function getStateName()
    {
        return $this->state_name;
    }

    /**
     * Set state_code
     *
     * @param string $stateCode
     * @return State
     */
    public function setStateCode($stateCode)
    {
        $this->state_code = $stateCode;
    
        return $this;
    }

    /**
     * Get state_code
     *
     * @return string 
     */
    public function getStateCode()
    {
        return $this->state_code;
    }
}