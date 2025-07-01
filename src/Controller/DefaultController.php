<?php

namespace App\Controller;

use App\Repository\DeskRepository;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(DeskRepository $deskRepository): Response
    {
        $desks = $deskRepository->findAll();
        return $this->render('desks/index.html.twig', [
            'desks' => $desks,
        ]);
    }

    #[Route('/bookings', name: 'booking_list', methods: ['GET'])]
    public function bookings(BookingRepository $bookingRepository): Response
    {
        $bookings = $bookingRepository->findAll();
        return $this->render('bookings/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }
}
