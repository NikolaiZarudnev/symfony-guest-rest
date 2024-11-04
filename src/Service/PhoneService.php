<?php

namespace App\Service;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use Psr\Log\LoggerInterface;

class PhoneService
{
    public function __construct(
        private readonly PhoneNumberUtil $phoneUtil,
        private readonly PhoneNumberOfflineGeocoder $numberOfflineGeocoder,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws NumberParseException
     */
    public function convertToPhoneNumber(string $phone): ?PhoneNumber
    {
        try {
            $phoneNumber = $this->phoneUtil->parse($phone, PhoneNumberUtil::UNKNOWN_REGION);
        } catch (NumberParseException $e) {
            $this->logger->warning('Invalid phone number');

            throw $e;
        }

        return $phoneNumber;
    }

}