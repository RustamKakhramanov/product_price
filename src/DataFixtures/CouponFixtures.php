<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $coupons = [
            ['code' => 'P10', 'discount' => 10, 'isPercentage' => true],
            ['code' => 'P100', 'discount' => 100, 'isPercentage' => true],
            ['code' => 'D15', 'discount' => 15, 'isPercentage' => false],
        ];

        foreach ($coupons as $data) {
            $coupon = new Coupon();
            $coupon->setCode($data['code']);
            $coupon->setDiscount($data['discount']);
            $coupon->setIsPercentage($data['isPercentage']);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}