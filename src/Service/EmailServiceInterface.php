<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ContactDto;

interface EmailServiceInterface
{
    /**
     * @param ContactDto $contactDto
     * @param string|null $attachmentContent Contenu binaire de la pièce jointe
     * @param string|null $attachmentFileName Nom de la pièce jointe
     */
    public function sendContactEmail(ContactDto $contactDto, ?string $attachmentContent = null, ?string $attachmentFileName = null): void;
}
