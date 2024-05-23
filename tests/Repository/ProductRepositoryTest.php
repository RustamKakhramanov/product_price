<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Product;

class ProductRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCreateAndFindProduct(): void
    {
        $product = new Product();
        $product->setName('Iphone');
        $product->setPrice(100.00);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $productRepository = $this->entityManager->getRepository(Product::class);
        $savedProduct = $productRepository->find($product->getId());

        $this->assertSame('Iphone', $savedProduct->getName());
        $this->assertSame(100.00, $savedProduct->getPrice());
    }

    public function testUpdateProduct(): void
    {
        $product = new Product();
        $product->setName('Iphone');
        $product->setPrice(100.00);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $productRepository = $this->entityManager->getRepository(Product::class);
        $savedProduct = $productRepository->find($product->getId());
        $savedProduct->setPrice(150.00);
        $this->entityManager->flush();

        $updatedProduct = $productRepository->find($product->getId());
        $this->assertSame(150.00, $updatedProduct->getPrice());
    }

    public function testDeleteProduct(): void
    {
        $product = new Product();
        $product->setName('Iphone');
        $product->setPrice(100.00);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $productRepository = $this->entityManager->getRepository(Product::class);
        $productId = $product->getId();

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        $deletedProduct = $productRepository->find($productId);
        $this->assertNull($deletedProduct);
    }

}

