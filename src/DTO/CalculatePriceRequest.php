<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\Constraints as CustomAssert;

class CalculatePriceRequest
{

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public $product;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[CustomAssert\TaxNumber]
    public $taxNumber;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public $couponCode;

}
