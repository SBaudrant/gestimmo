<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\PasswordEmailTrigger;
use App\Exception\AppRuntimeException;
use Random\Randomizer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class PasswordService
{
    private const RESET_PASSWORD_VALIDITY = 'PT30M';
    private const TOKEN_LENGTH = 20;

    public function __construct(
        private UserPasswordHasherInterface $encoder,
        private EmailService $emailService,
        private TranslatorInterface $translator,
        #[Autowire(env: 'FRONT_BASE_URL')]
        private string $frontBaseUrl,
        #[Autowire(env: 'INIT_PASSWORD_VALIDITY')]
        private string $initPasswordValidity,
    ) {
    }

    /**
     * Envoi à l'utilisateur un email pour lui permettre de modifier son mot de passe via un token.
     * Il faut d'abord avoir appelé la méthode {@see self::initPasswordResetProcess()}
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendEmail(User $user, PasswordEmailTrigger $passwordEmailTrigger): void
    {
        if ($user->getInitPasswordToken() === null) {
            throw new AppRuntimeException('L\'utilisateur n\'a pas de token de modification de mot de passe. Il faut d\'abord appeler la méthode initPasswordResetProcess');
        }

        $mailSubject = match ($passwordEmailTrigger) {
            PasswordEmailTrigger::NEW_USER => $this->translator->trans('NewUser.Mail.Subject'),
            PasswordEmailTrigger::RESET_PASSWORD => $this->translator->trans('InitPassword.Mail.Subject'),
        };
        $emailTemplate = match ($passwordEmailTrigger) {
            PasswordEmailTrigger::NEW_USER => 'email/account_created.html.twig',
            PasswordEmailTrigger::RESET_PASSWORD => 'email/init_password.html.twig',
        };

        $this->emailService->send(
            [$user->getEmail()],
            $mailSubject,
            $emailTemplate,
            [
                'user' => $user,
                'setPasswordUrl' => sprintf('%s/init_password/%s', $this->frontBaseUrl, $user->getInitPasswordToken()),
            ],
        );
    }

    /**
     * Prépare le processus de modification de mot de passe d'un utilisateur via un token.
     */
    public function initPasswordResetProcess(User $user): void
    {
        if ($user->getPassword() === null) {
            try {
                $tokenDuration = new \DateInterval($this->initPasswordValidity);
            } catch (\Exception $e) {
                throw new AppRuntimeException('La durée de vie du token pour la création d\'un utilisateur n\'est pas valide', 0, $e);
            }
        } else {
            $tokenDuration = new \DateInterval(self::RESET_PASSWORD_VALIDITY);
        }

        $tokenExpiration = (new \DateTimeImmutable())->add($tokenDuration);

        $user
            ->setInitPasswordTokenExpiration($tokenExpiration)
            ->setInitPasswordToken($this->generateToken())
        ;
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     * (Ne persiste pas la modification.)
     */
    public function setEncodedPassword(User $user, string $plainPassword): void
    {
        $password = $this->encoder->hashPassword($user, $plainPassword);
        $user->setPassword($password);
    }

    /**
     * Génère le token utilisé pour permettre à un utilisateur de (ré)initialiser son mot de passe.
     */
    private function generateToken(): string
    {
        $randomizer = new Randomizer();
        $randomBytes = $randomizer->getBytes(64);
        $hash = hash('sha3-512', $randomBytes);

        return substr($hash, 0, self::TOKEN_LENGTH);
    }
}
