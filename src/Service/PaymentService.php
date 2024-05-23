<?php

namespace App\Service;

use App\Enum\PaymentTypeEnum;
use App\Payment\PaypalPaymentProcessor;
use App\Payment\StripePaymentProcessor;


class PaymentService
{

    public function __construct(private PaypalPaymentProcessor $paypalProcessor, private StripePaymentProcessor $stripeProcessor)
    {
    }

    public function processPayment(string $processor, float $amount): bool
    {
        switch ($processor) {
            case PaymentTypeEnum::Paypal->value:
                return $this->paypalProcessor->pay($amount);
            case PaymentTypeEnum::Stripe->value:
                return $this->stripeProcessor->processPayment($amount);
            default:
                throw new \InvalidArgumentException('Invalid payment processor.');
        }
    }
}
