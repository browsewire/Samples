<?php
namespace RAR\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class WebControllerTest extends WebTestCase
{
public function testRealtors()
{
$client = static::createClient();
$crawler = $client->request('GET', '/realtors');
$this->assertEquals(1, $crawler->filter('h1:contains("rahul")')->count());

}

}
?>
