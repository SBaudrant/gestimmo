<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

final class UserPasswordResetRequest
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        public readonly string $email = '',
    ) {
    }
}
