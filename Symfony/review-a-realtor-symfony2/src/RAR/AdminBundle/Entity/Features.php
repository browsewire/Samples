<?php

namespace RAR\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Features
 */
class Features
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $code;
}
