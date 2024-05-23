<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Coupon;

class CouponRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCreateAndFindCoupon(): void
    {
        $coupon = new Coupon();
        $coupon->setCode('P10');
        $coupon->setDiscount(10.00);
        $coupon->setIsPercentage(true);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $couponRepository = $this->entityManager->getRepository(Coupon::class);
        $savedCoupon = $couponRepository->find($coupon->getId());

        $this->assertSame('P10', $savedCoupon->getCode());
        $this->assertSame(10.00, $savedCoupon->getDiscount());
        $this->assertTrue($savedCoupon->getIsPercentage());
    }

    public function testUpdateCoupon(): void
    {
        $coupon = new Coupon();
        $coupon->setCode('P10');
        $coupon->setDiscount(10.00);
        $coupon->setIsPercentage(true);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $couponRepository = $this->entityManager->getRepository(Coupon::class);
        $savedCoupon = $couponRepository->find($coupon->getId());
        $savedCoupon->setDiscount(15.00);
        $this->entityManager->flush();

        $updatedCoupon = $couponRepository->find($coupon->getId());
        $this->assertSame(15.00, $updatedCoupon->getDiscount());
    }

    public function testDeleteCoupon(): void
    {
        $coupon = new Coupon();
        $coupon->setCode('P10');
        $coupon->setDiscount(10.00);
        $coupon->setIsPercentage(true);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $couponRepository = $this->entityManager->getRepository(Coupon::class);
        $couponId = $coupon->getId();

        $this->entityManager->remove($coupon);
        $this->entityManager->flush();

        $deletedCoupon = $couponRepository->find($couponId);
        $this->assertNull($deletedCoupon);
    }
}

