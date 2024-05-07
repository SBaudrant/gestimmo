<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\PasswordEmailTrigger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PasswordService $passwordService,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function create(User $user): void
    {
        // Actions pouvant être effectuées avant que l'utilisateur soit enregistré en base.
        // À cet endroit, il n'a pas encore d'identifiant.
        $this->passwordService->initPasswordResetProcess($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Actions effectuées après que l'utilisateur ait été enregistré en base.
        $this->passwordService->sendEmail($user, PasswordEmailTrigger::NEW_USER);
    }

    /**
     * Envoi un e-mail à l'utilisateur pour lui permettre de réinitialiser son mot de passe.
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function resetPassword(User $user): void
    {
        $this->passwordService->initPasswordResetProcess($user);
        $this->entityManager->flush();

        $this->passwordService->sendEmail($user, PasswordEmailTrigger::RESET_PASSWORD);
    }

    public function updatePassword(User $user, string $newPassword): void
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));
        $user->setInitPasswordTokenExpiration(null);
        $user->setInitPasswordToken(null);

        $this->entityManager->flush();
    }
}
