<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testProductCreation(): void
    {
        $product = new Product();
        $product->setName('Iphone');
        $product->setPrice(100.00);

        $this->assertEquals('Iphone', $product->getName());
        $this->assertEquals(100.00, $product->getPrice());
    }

    public function testProductPrice(): void
    {
        $product = new Product();
        $product->setPrice(99.99);

        $this->assertIsFloat($product->getPrice());
        $this->assertEquals(99.99, $product->getPrice());
    }
}