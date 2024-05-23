<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $discount = null;

    #[ORM\Column]
    private ?int $discountType = null;

    #[ORM\Column]
    private $isPercentage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDiscountType(): ?int
    {
        return $this->discountType;
    }

    public function setDiscountType(int $discountType): static
    {
        $this->discountType = $discountType;

        return $this;
    }
    public function getIsPercentage(): ?int
    {
        return $this->isPercentage;
    }

    public function setIsPercentage(int $discountType): static
    {
        $this->isPercentage = $discountType;

        return $this;
    }
}
