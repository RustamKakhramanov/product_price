<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"SEQUENCE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product_id = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_processor = null;

    #[ORM\Column(length: 255)]
    private ?string $taxnumber = null;

    #[ORM\Column(length: 255)]
    private ?string $coupon_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getPaymentProcessor(): ?string
    {
        return $this->payment_processor;
    }

    public function setPaymentProcessor(string $payment_processor): static
    {
        $this->payment_processor = $payment_processor;

        return $this;
    }

    public function getTaxnumber(): ?string
    {
        return $this->taxnumber;
    }

    public function setTaxnumber(string $taxnumber): static
    {
        $this->taxnumber = $taxnumber;

        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->coupon_code;
    }

    public function setCouponCode(string $coupon_code): static
    {
        $this->coupon_code = $coupon_code;

        return $this;
    }
}
