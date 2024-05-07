<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ComposeValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     * @param Compose $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        $context = $this->context;
        $validator = $context
            ->getValidator()
            ->startContext()
        ;

        $violations = $validator
            ->validate($value, $constraint->constraints)
            ->getViolations()
        ;

        $validated = count($constraint->constraints) - count($violations);
        $min = $constraint->min;
        $max = $constraint->max;

        if ($validated < $min) {
            $context
                ->buildViolation($constraint->minMessage)
                ->addViolation()
            ;

            return;
        }

        if ($max !== null && $validated > $max) {
            $context
                ->buildViolation($constraint->maxMessage)
                ->addViolation()
            ;

            return;
        }
    }
}
