<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ContactDto;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
        $email = (new Email())
            ->from($this->contactEmail)
            ->to($this->contactEmail)
            ->subject(sprintf('%s %s %s', $contactDto->subject, $contactDto->email, $contactDto->name))
            ->text((string) $contactDto->message);

        if (null !== $attachmentContent) {
            $email->attach($attachmentContent);
        }

        $this->mailer->send($email);
    }
}
