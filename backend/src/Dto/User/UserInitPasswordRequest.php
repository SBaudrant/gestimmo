<?php

namespace App\Dto\User;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\User;
use App\Validator\Compose;
use App\Validator\InitTokenValid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class UserInitPasswordRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    #[Compose(
        constraints: [
            new Assert\Regex('/[a-z]/'),
            new Assert\Regex('/[A-Z]/'),
            new Assert\Regex('/[0-9]/'),
            new Assert\Regex('/[.,;:!?\\/@#()]/'),
        ],
        min: 3,
        minMessage: 'Le mot de passe doit contenir au moins 3 des éléments suivants : minuscules, majuscules, chiffres et caractères spéciaux.',
    )]
    #[Groups(['user:initPassword'])]
    public string $password;

    public function __construct(
        #[InitTokenValid]
        #[ApiProperty(identifier: true)]
        public readonly User $user,
    ) {
    }
}
