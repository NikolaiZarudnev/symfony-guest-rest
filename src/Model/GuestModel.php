<?php

namespace App\Model;

use App\Dto\GuestDto;
use App\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;

class GuestModel
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createFromDto(GuestDto $guestDto): Guest
    {
        $guest = new Guest();
        $this->updateFromDto($guest, $guestDto);

        return $guest;
    }

    public function updateFromDto(Guest $guest, GuestDto $guestDto): Guest
    {
        $guest
            ->setEmail($guestDto->getEmail())
            ->setFirstName($guestDto->getFirstName())
            ->setLastName($guestDto->getLastName())
            ->setPhone($guestDto->getPhone())
            ->setCountry($guestDto->getCountry())
        ;

        return $guest;
    }

    public function save(Guest $guest): void
    {
        $this->entityManager->persist($guest);
        $this->entityManager->flush();
    }

    public function asArray(Guest $guest): array
    {
        return [
            'id' => $guest->getId(),
            'firstName' => $guest->getFirstName(),
            'lastName' => $guest->getLastName(),
            'phone' => $guest->getPhone(),
            'email' => $guest->getEmail(),
            'country' => $guest->getCountry(),
        ];
    }
    public function delete(Guest $guest): void
    {
        $this->entityManager->remove($guest);
        $this->entityManager->flush();
    }
}