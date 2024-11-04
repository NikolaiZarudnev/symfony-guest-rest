<?php

namespace App\Traits;

use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ViolationsConverter
{
    public function convertToArray(ConstraintViolationListInterface $list): array
    {
        $messages = [];

        if (count($list) > 0) {
            foreach ($list as $error) {
                $messages['errors'][] = [
                    'property' => $error->getPropertyPath(),
                    'value' => $error->getInvalidValue(),
                    'message' => $error->getMessage(),
                ];
            }
        }

        return $messages;
    }
}