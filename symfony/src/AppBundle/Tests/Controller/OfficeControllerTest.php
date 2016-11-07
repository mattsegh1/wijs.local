<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OfficeControllerTest extends WebTestCase
{
    public function testOfficesSearch()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/offices?location=Gent&range=10&weekend=N&support=N');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('results', $data);
    }

}
