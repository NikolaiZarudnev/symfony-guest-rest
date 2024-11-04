<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GuestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private readonly ?string $firstName = null,
        #[Assert\NotBlank]
        private readonly ?string $lastName = null,
        #[Assert\NotBlank]
        #[Assert\Regex('/^\+?[0-9]+$/')]
        private readonly ?string $phone = null,
        #[Assert\Email]
        private ?string          $email = null,
        private ?string          $country = null,
    ) {
        $this->email = empty($email) ? null : $email;
        $this->country = empty($country) ? null : $country;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }
}
