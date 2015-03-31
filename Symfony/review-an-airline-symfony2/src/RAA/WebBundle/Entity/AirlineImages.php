<?php
namespace RAA\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="raa_airline_images")
 */
class AirlineImages
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
    public $airline_id;
 /**
     * @ORM\Column(type="string")
     */
    public $image_url;
      /**
     * @ORM\Column(type="text")
     */
    public $image_caption;
    
    
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
     * Set airline_id
     *
     * @param integer $airlineId
     * @return AirlineImages
     */
    public function setAirlineId($airlineId)
    {
        $this->airline_id = $airlineId;
    
        return $this;
    }

    /**
     * Get airline_id
     *
     * @return integer 
     */
    public function getAirlineId()
    {
        return $this->airline_id;
    }

    /**
     * Set image_url
     *
     * @param string $imageUrl
     * @return AirlineImages
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;
    
        return $this;
    }

    /**
     * Get image_url
     *
     * @return string 
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Set image_caption
     *
     * @param string $imageCaption
     * @return AirlineImages
     */
    public function setImageCaption($imageCaption)
    {
        $this->image_caption = $imageCaption;
    
        return $this;
    }

    /**
     * Get image_caption
     *
     * @return string 
     */
    public function getImageCaption()
    {
        return $this->image_caption;
    }
}