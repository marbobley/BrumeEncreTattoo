<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ContactDto;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService implements EmailServiceInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $contactEmail = 'contact@brumedencre-tattoo.fr',
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendContactEmail(ContactDto $contactDto, ?string $attachmentContent = null): void
    {
        $adresseBrume = new Address($this->contactEmail, "Brume d'Encre");

        $email = (new TemplatedEmail())
            ->from($adresseBrume)
            ->to($adresseBrume)
            ->subject($contactDto->subject)
            ->textTemplate('Email/contact-email.txt.twig')
            ->htmlTemplate('Email/contact-email.html.twig')
            ->context([
                'contact' => $contactDto,
            ])
        ;

        if (null !== $attachmentContent) {
            $email->attach($attachmentContent);
        }

        $this->mailer->send($email);
    }
}
