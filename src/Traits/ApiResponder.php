<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ApiResponder
{

    public function createResponse($data, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            $data,
            $status,
            $headers,
            !is_array($data));
    }

    public function createFailedValidationResponse(ConstraintViolationListInterface $list, array $headers = []): JsonResponse
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

        return $this->createResponse($messages, Response::HTTP_BAD_REQUEST, $headers);
    }
}