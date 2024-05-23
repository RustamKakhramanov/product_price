<?php

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;

class PriceCalculationService
{
    public function calculatePrice(Product $product, ?Coupon $coupon, string $taxNumber): float
    {
        $price = $product->getPrice();
        
        if ($coupon) {
            if ($coupon->getIsPercentage()) {
                $price -= $price * ($coupon->getDiscount() / 100);
            } else {
                $price -= $coupon->getDiscount();
            }
        }

        $taxRate = $this->getTaxRate($taxNumber);
        $price += $price * ($taxRate / 100);

        return $price;
    }

    private function getTaxRate(string $taxNumber): float
    {
        switch (substr($taxNumber, 0, 2)) {
            case 'DE':
                return 19;
            case 'IT':
                return 22;
            case 'GR':
                return 24;
            case 'FR':
                return 20;
            default:
                throw new \InvalidArgumentException('Invalid tax number.');
        }
    }

}
