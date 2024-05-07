<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class EmailService
{
    public function __construct(
        #[Autowire(env: 'MAILER_SENDER_EMAIL')]
        private string $mailerSenderEmail,
        #[Autowire(env: 'MAILER_SENDER_NAME')]
        private string $mailerSenderName,
        private MailerInterface $mailer,
    ) {
    }

    /**
     * Envoi un email en remplissant automatiquement les champs communs.
     *
     * @param string[]|Address[] $to Adresses auxquelles envoyer l'email.
     * @param string $subject L'objet du mail.
     * @param string $template Le template à utiliser pour générer le mail.
     * @param array $parameters Les paramètres du template à utiliser.
     *
     * @throws TransportExceptionInterface
     */
    public function send(array $to, string $subject, string $template, array $parameters): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->mailerSenderEmail, $this->mailerSenderName))
            ->to(...$to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($parameters)
        ;

        $this->mailer->send($email);
    }
}
