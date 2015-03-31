<?php

namespace RAR\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rar_plan_feature")
 */
class PlanFeatures
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
    public $plan_id;

  	
    /**
     * @ORM\Column(type="integer")
     */
    public $feature_id;




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
     * Set plan_id
     *
     * @param integer $planId
     * @return PlanFeatures
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
     * Set feature_id
     *
     * @param integer $featureId
     * @return PlanFeatures
     */
    public function setFeatureId($featureId)
    {
        $this->feature_id = $featureId;
    
        return $this;
    }

    /**
     * Get feature_id
     *
     * @return integer 
     */
    public function getFeatureId()
    {
        return $this->feature_id;
    }
}