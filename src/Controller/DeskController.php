<?php

namespace App\Controller;

use App\Repository\DeskRepository;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeskController extends AbstractController
{
    #[Route('/desks', name: 'desk_list', methods: ['GET'])]
    public function list(DeskRepository $deskRepository, BookingRepository $bookingRepository): JsonResponse
    {
        $desks = $deskRepository->findAll();
        $data = [];
        foreach ($desks as $desk) {
            $active = $bookingRepository->findActiveForDesk($desk) !== null;
            $data[] = [
                'id' => $desk->getId(),
                'name' => $desk->getName(),
                'occupied' => $active,
            ];
        }
        return $this->json($data);
    }
}
