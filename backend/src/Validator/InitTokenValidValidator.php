<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InitTokenValidValidator extends ConstraintValidator
{
    /**
     * @param \App\Entity\User $value
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var InitTokenValid $constraint */

        if ($value->getInitPasswordTokenExpiration() < new \DateTime()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
