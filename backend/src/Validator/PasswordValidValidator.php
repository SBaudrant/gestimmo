<?php

namespace App\Validator;

use App\Dto\User\UserUpdatePasswordRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidValidator extends ConstraintValidator
{
    public function __construct(private UserPasswordHasherInterface $userPasswordEncoder)
    {
    }

    /**
     * @param \App\Dto\User\UserUpdatePasswordRequest $value
     */
    public function validate($value, Constraint $constraint): void
    {
        assert($value instanceof UserUpdatePasswordRequest);
        assert($constraint instanceof PasswordValid);

        if ($this->userPasswordEncoder->isPasswordValid($value->getUser(), $value->getOldPassword())) {
            return;
        }

        $this->context->buildViolation($constraint->message)->atPath('oldPassword')->addViolation();
    }
}
