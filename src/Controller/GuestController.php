<?php

namespace App\Controller;

use App\Dto\GuestDto;
use App\Entity\Guest;
use App\Model\GuestModel;
use App\Repository\GuestRepository;
use App\Traits\ApiResponder;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GuestController extends AbstractController
{
    use ApiResponder;

    public function __construct(
        private readonly GuestRepository $guestRepository,
        private readonly GuestModel $guestModel,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/guest', name: 'guest_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $this->startTime = getrusage()["ru_utime.tv_usec"];

        $guests = $this->guestRepository->findAll();

        $data = [];
        foreach ($guests as $guest) {
            $data[] = $this->guestModel->asArray($guest);
        }

        return $this->createResponse([
            'guests' => $data,
        ]);
    }

    #[Route('/guest', name: 'guest_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $this->startTime = getrusage()["ru_utime.tv_usec"];

        $guestCreateDto = $this->serializer->denormalize(
            $request->request->all(),
            GuestDto::class
        );

        $errors = $this->validator->validate($guestCreateDto);
        if (count($errors) > 0) {
            return $this->createFailedValidationResponse($errors);
        }

        try {
            $guest = $this->guestModel->createFromDto($guestCreateDto);
        } catch (\Exception $exception) {
            return $this->createResponse([
                'error' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $errors = $this->validator->validate($guest);
        if (count($errors) > 0) {
            return $this->createFailedValidationResponse($errors);
        }

        $this->guestModel->save($guest);

        return $this->createResponse([], Response::HTTP_CREATED);
    }

    #[Route('/guest/{id}', name: 'guest_show', methods: ['GET'])]
    public function show(?Guest $guest): JsonResponse
    {
        $this->startTime = getrusage()["ru_utime.tv_usec"];

        if (null === $guest) {
            return $this->createResponse([], Response::HTTP_NOT_FOUND);
        }

        $data = $this->guestModel->asArray($guest);

        return $this->createResponse([
            'guest' => $data,
        ]);
    }

    #[Route('/guest/{id}', name: 'guest_update', methods: ['PUT'])]
    public function update(?Guest $guest, Request $request): JsonResponse
    {
        $this->startTime = getrusage()["ru_utime.tv_usec"];

        if (null === $guest) {
            return $this->createResponse([], Response::HTTP_NOT_FOUND);
        }

        $guestUpdateDto = $this->serializer->denormalize(
            $request->request->all(),
            GuestDto::class
        );

        $errors = $this->validator->validate($guestUpdateDto);
        if (count($errors) > 0) {
            return $this->createFailedValidationResponse($errors);
        }

        try {
            $guest = $this->guestModel->updateFromDto($guest, $guestUpdateDto);
        } catch (\Exception $exception) {
            return $this->createResponse([
                'error' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $errors = $this->validator->validate($guest);
        if (count($errors) > 0) {
            return $this->createFailedValidationResponse($errors);
        }

        $this->guestModel->save($guest);

        return $this->createResponse([]);
    }

    #[Route('/guest/{id}', name: 'guest_delete', methods: ['DELETE'])]
    public function delete(?Guest $guest): JsonResponse
    {
        $this->startTime = getrusage()["ru_utime.tv_usec"];

        if (null === $guest) {
            return $this->createResponse([], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->guestModel->delete($guest);
        } catch (Exception $exception) {
            return $this->createResponse([
                'error' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->createResponse([]);
    }
}
