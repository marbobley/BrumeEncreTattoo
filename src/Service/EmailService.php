<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService implements EmailServiceInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $contactEmail = 'contact@brumedencre-tattoo.fr'
    ) {
    }

    public function sendContactEmail(array $data, ?string $attachmentContent = null): void
    {
        $email = (new Email())
            ->from($this->contactEmail)
            ->to($this->contactEmail)
            ->subject(sprintf('%s %s %s', $data['subject'], $data['email'], $data['name']))
            ->text($data['message']);

        if ($attachmentContent !== null) {
            $email->attach($attachmentContent);
        }

        $this->mailer->send($email);
    }
}
