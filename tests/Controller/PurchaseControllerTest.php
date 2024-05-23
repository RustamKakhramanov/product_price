<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function testPurchase(): void
    {
        $client = static::createClient();

        $client->request('POST', '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15',
            'paymentProcessor' => 'paypal'
        ]));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseContent);
    }


    public function testPurchaseInvalidData(): void
    {
        $client = static::createClient();

        $client->request('POST', '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 'invalid',
            'taxNumber' => 'INVALID',
            'couponCode' => 'INVALID',
            'paymentProcessor' => 'INVALID'
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
    }
}