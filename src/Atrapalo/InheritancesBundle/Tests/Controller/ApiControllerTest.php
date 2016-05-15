<?php

namespace Atrapalo\InheritancesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        //$crawler = $client->request('GET', '/v1/heritage/julia/01-01-2075');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }
}
