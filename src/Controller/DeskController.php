<?php

namespace App\Controller;

use App\Repository\DeskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeskController extends AbstractController
{
    #[Route('/desks', name: 'desk_list', methods: ['GET'])]
    public function list(DeskRepository $deskRepository): JsonResponse
    {
        $desks = $deskRepository->findAll();
        $data = array_map(fn($desk) => ['id' => $desk->getId(), 'name' => $desk->getName()], $desks);
        return $this->json($data);
    }
}
