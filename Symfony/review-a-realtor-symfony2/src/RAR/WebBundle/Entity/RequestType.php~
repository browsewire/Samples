<?php
namespace RAR\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_request_type")
 */
class RequestType
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
    public $description;
    

    /**
     * @ORM\Column(type="string")
     */
    public $req_code;
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
     * Set description
     *
     * @param string $description
     * @return RequestType
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
     * Set req_code
     *
     * @param string $reqCode
     * @return RequestType
     */
    public function setReqCode($reqCode)
    {
        $this->req_code = $reqCode;
    
        return $this;
    }

    /**
     * Get req_code
     *
     * @return string 
     */
    public function getReqCode()
    {
        return $this->req_code;
    }
}