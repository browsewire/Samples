<?php
namespace RAA\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="raa_detail")
 */
class AirlineDetail
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
    public $left_tab_heading;
    
        /**
     * @ORM\Column(type="string")
     */
    public $tab_html;
       
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
     * @return AirlineDetail
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
     * Set left_tab_heading
     *
     * @param string $leftTabHeading
     * @return AirlineDetail
     */
    public function setLeftTabHeading($leftTabHeading)
    {
        $this->left_tab_heading = $leftTabHeading;
    
        return $this;
    }

    /**
     * Get left_tab_heading
     *
     * @return string 
     */
    public function getLeftTabHeading()
    {
        return $this->left_tab_heading;
    }

    /**
     * Set tab_html
     *
     * @param string $tabHtml
     * @return AirlineDetail
     */
    public function setTabHtml($tabHtml)
    {
        $this->tab_html = $tabHtml;
    
        return $this;
    }

    /**
     * Get tab_html
     *
     * @return string 
     */
    public function getTabHtml()
    {
        return $this->tab_html;
    }
}