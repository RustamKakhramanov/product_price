<?php

namespace App\Service;

use App\Enum\PaymentTypeEnum;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;


class PaymentService
{

    public function __construct(private PaypalPaymentProcessor $paypalProcessor, private StripePaymentProcessor $stripeProcessor)
    {
    }

    public function processPayment(string $processor, float $amount): bool
    {
        switch ($processor) {
            case PaymentTypeEnum::Paypal->value:
                $this->paypalProcessor->pay($amount);
                return true;
            case PaymentTypeEnum::Stripe->value:
                return $this->stripeProcessor->processPayment($amount);
            default:
                throw new \InvalidArgumentException('Invalid payment processor.');
        }
    }
}
