<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDto
{
    #[Assert\NotBlank(message: 'Merci de renseigner votre nom.')]
    public ?string $name = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre email.')]
    #[Assert\Email(message: 'L\'adresse email n\'est pas valide.')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'Merci de renseigner un sujet.')]
    public ?string $subject = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre message.')]
    public ?string $message = null;
}
