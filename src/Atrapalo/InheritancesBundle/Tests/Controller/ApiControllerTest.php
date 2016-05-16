<?php

namespace Atrapalo\InheritancesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testGetHeritage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/v1/heritage/julia/01-01-2075');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        die($crawler->html());
    }

}