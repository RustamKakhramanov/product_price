<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends CalculatePriceRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Choice(["paypal", "stripe"])]
    public $paymentProcessor;
}
