<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ContactDto;

interface EmailServiceInterface
{
    /**
     * @param ContactDto $contactDto
     * @param array<int, array{content: string, fileName: string}> $attachments
     */
    public function sendContactEmail(ContactDto $contactDto, array $attachments = []): void;
}
