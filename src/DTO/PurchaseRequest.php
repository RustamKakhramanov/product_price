<?php

namespace App\DTO;

use App\Enum\PaymentTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends CalculatePriceRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Choice(callback: [PaymentTypeEnum::class, 'getTypes'])]
    public $paymentProcessor;
}
