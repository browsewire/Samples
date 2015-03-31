<?php
namespace RAA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="raa_city")
 */
class City
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
    public $city_name;

 		
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
     * Set city_name
     *
     * @param string $cityName
     * @return City
     */
    public function setCityName($cityName)
    {
        $this->city_name = $cityName;
    
        return $this;
    }

    /**
     * Get city_name
     *
     * @return string 
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * Set state_code
     *
     * @param string $stateCode
     * @return City
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