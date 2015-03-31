<?php
namespace RAA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="raa_advertiesment")
 */
class Advertiesment
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
    public $title;

    /**
     * @ORM\Column(type="string")
     */
    public $description;

    /**
     * @ORM\Column(type="string")
     */
    public $type;

    /**
     * @ORM\Column(type="string")
     */
    public $image;

    /**
     * @ORM\Column(type="string")
     */
    public $target_url;

    
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
     * Set title
     *
     * @param string $title
     * @return Advertiesment
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Advertiesment
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Advertiesment
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
     * Set target_url
     *
     * @param string $targetUrl
     * @return Advertiesment
     */
    public function setTargetUrl($targetUrl)
    {
        $this->target_url = $targetUrl;
    
        return $this;
    }

    /**
     * Get target_url
     *
     * @return string 
     */
    public function getTargetUrl()
    {
        return $this->target_url;
    }

    /**
     * Set creator_id
     *
     * @param integer $creatorId
     * @return Advertiesment
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
     * @return Advertiesment
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
     * @return Advertiesment
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
     * @return Advertiesment
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
     * @param string $type
     * @return Advertiesment
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
}