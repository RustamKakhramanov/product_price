<?php
namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Coupon;

class CouponTest extends TestCase
{
    public function testCouponCreation(): void
    {
        $coupon = new Coupon();
        $coupon->setCode('P10');
        $coupon->setDiscount(10.00);
        $coupon->setIsPercentage(true);

        $this->assertEquals('P10', $coupon->getCode());
        $this->assertEquals(10.00, $coupon->getDiscount());
        $this->assertTrue($coupon->getIsPercentage());
    }

    public function testCouponDiscount(): void
    {
        $coupon = new Coupon();
        $coupon->setDiscount(15.50);

        $this->assertIsFloat($coupon->getDiscount());
        $this->assertEquals(15.50, $coupon->getDiscount());
    }

    public function testCouponType(): void
    {
        $coupon = new Coupon();
        $coupon->setIsPercentage(false);

        $this->assertFalse($coupon->getIsPercentage());
    }
}
