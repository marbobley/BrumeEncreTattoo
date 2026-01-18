<?php

declare(strict_types=1);

namespace App\Service;

interface EmailServiceInterface
{
    /**
     * @param array{email: string, name: string, subject: string, message: string} $data
     * @param string|null $attachmentContent Contenu binaire de la pièce jointe
     */
    public function sendContactEmail(array $data, ?string $attachmentContent = null): void;
}
