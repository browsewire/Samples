<?php
namespace RAR\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_property_images")
 */
class PropertyImages
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
    public $property_id;
 /**
     * @ORM\Column(type="string")
     */
    public $image_url;
     
     /**
     * @ORM\Column(type="integer")
     */
    public $is_main;
     
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
     * Set property_id
     *
     * @param integer $propertyId
     * @return PropertyImages
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
     * Set image_url
     *
     * @param string $imageUrl
     * @return PropertyImages
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;
    
        return $this;
    }

    /**
     * Get image_url
     *
     * @return integer 
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Set is_main
     *
     * @param string $isMain
     * @return PropertyImages
     */
    public function setIsMain($isMain)
    {
        $this->is_main = $isMain;
    
        return $this;
    }

    /**
     * Get is_main
     *
     * @return integer 
     */
    public function getIsMain()
    {
        return $this->is_main;
    }
}