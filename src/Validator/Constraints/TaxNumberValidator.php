<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        if (!preg_match('/^([A-Z]{2})([A-Z0-9]{9,12})$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ country }}', 'Unknown')
                ->addViolation();
            return;
        }

        $countryCode = $matches[1];
        $number = $matches[2];

        $patterns = [
            'DE' => '/^[0-9]{9}$/',
            'IT' => '/^[0-9]{11}$/',
            'GR' => '/^[0-9]{9}$/',
            'FR' => '/^[A-Z]{2}[0-9]{9}$/',
        ];

        if (!isset($patterns[$countryCode]) || !preg_match($patterns[$countryCode], $number)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ country }}', $countryCode)
                ->addViolation();
        }
    }
}