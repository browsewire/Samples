<?php
// src/Blogger/BlogBundle/Tests/Entity/BlogTest.php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
namespace RAR\AdminBundle\Tests\Entity;
use RAR\AdminBundle\Entity\User;
class UserTest extends \PHPUnit_Framework_TestCase
{

 public function testSetFirstName()
    {
         $user = new User();

        $this->assertEquals('hello-world', user::('Hello World'));
    }
 
}
