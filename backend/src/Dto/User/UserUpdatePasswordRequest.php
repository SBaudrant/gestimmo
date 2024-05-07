<?php

namespace App\Dto\User;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\User;
use App\Validator\Compose;
use App\Validator\PasswordValid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[PasswordValid]
final class UserUpdatePasswordRequest
{
    private User $user;

    #[Groups(['userUpdatePasswordRequest:put'])]
    private string $oldPassword = '';

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
        minMessage: 'UserUpdatePassword.NewPasswordInvalid',
    )]
    #[Groups(['userUpdatePasswordRequest:put'])]
    private string $newPassword = '';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }
}
