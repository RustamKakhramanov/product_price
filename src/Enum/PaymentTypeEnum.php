<?php

namespace App\Enum;

enum PaymentTypeEnum:string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';


    public static function getTypes(){
        return [
            self::Paypal->value,
            self::Stripe->value,
        ];
    }
}
