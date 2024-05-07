<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

use function Symfony\Component\Translation\t;

#[\Attribute]
class InitTokenValid extends Constraint
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
            $this->message = t('UserInitPassword.ExpiredToken', [], 'validators')->getMessage();
        } else {
            $this->message = $message;
        }
    }

    public function validatedBy(): string
    {
        return InitTokenValidValidator::class;
    }
}
