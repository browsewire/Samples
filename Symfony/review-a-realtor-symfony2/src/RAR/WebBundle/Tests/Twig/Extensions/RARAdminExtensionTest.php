<?php
class RARAdminExtensionTest extends \PHPUnit_Framework_TestCase
{

public function testIndex()
{
$client = static::createClient();
$crawler = $client->request('GET', '/');
$this->assertGreaterThan(0, $crawler->filter('html:contains("What will you find on Review a Realtor?")')->count());
}

}
?>
