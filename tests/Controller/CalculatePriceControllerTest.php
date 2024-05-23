<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatePriceControllerTest  extends WebTestCase
{
    public function testCalculatePrice(): void
    {
        $client = static::createClient();

        $client->request('POST', '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15'
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('price', $responseContent);
    }

    public function testCalculatePriceInvalidData(): void
    {
        $client = static::createClient();

        $client->request('POST', '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 'invalid',
            'taxNumber' => 'INVALID',
            'couponCode' => 'INVALID'
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
    }

}

