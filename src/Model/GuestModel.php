<?php

namespace App\Model;

use App\Dto\GuestDto;
use App\Entity\Guest;
use App\Service\PhoneService;
use Doctrine\ORM\EntityManagerInterface;
use libphonenumber\NumberParseException;

class GuestModel
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PhoneService $phoneService,
    ) {
    }

    /**
     * @throws NumberParseException
     */
    public function createFromDto(GuestDto $guestDto): Guest
    {
        $guest = new Guest();
        $this->updateFromDto($guest, $guestDto);

        return $guest;
    }

    /**
     * @throws NumberParseException
     */
    public function updateFromDto(Guest $guest, GuestDto $guestDto): Guest
    {
        $phone = $this->phoneService->convertToPhoneNumber($guestDto->getPhone());
        $guest
            ->setEmail($guestDto->getEmail())
            ->setFirstName($guestDto->getFirstName())
            ->setLastName($guestDto->getLastName())
            ->setCountry($guestDto->getCountry())
            ->setPhone($phone)
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