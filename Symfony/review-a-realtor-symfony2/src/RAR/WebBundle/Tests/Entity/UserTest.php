<?php
namespace RAR\WebBundle\Tests\Entity;
use RAR\WebBundle\Entity\User;
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $blog = new Blog();

        $this->assertEquals('hello-world', $blog->slugify('Hello World'));
    }
}


