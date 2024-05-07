<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

use function Symfony\Component\Translation\t;

#[\Attribute(\Attribute::TARGET_CLASS)]
class PasswordValid extends Constraint
{
    public string $message;

    public function __construct(
        ?string $message = null,
        $options = null,
        array $groups = null,
        $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
        if ($message === null) {
            $this->message = t('UserUpdatePassword.OldPasswordInvalid', [], 'validators')->getMessage();
        } else {
            $this->message = $message;
        }
    }

    public function validatedBy(): string
    {
        return PasswordValidValidator::class;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
