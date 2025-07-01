<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\DeskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/bookings', name: 'booking_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, DeskRepository $deskRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $desk = isset($data['desk_id']) ? $deskRepository->find($data['desk_id']) : null;
        if (!$desk) {
            return $this->json(['error' => 'Desk not found'], 404);
        }

        $booking = new Booking();
        $booking->setDesk($desk);
        $booking->setUser($data['user'] ?? '');
        $booking->setStartTime(new \DateTime($data['start_time'] ?? 'now'));
        $booking->setEndTime(new \DateTime($data['end_time'] ?? 'now'));

        $em->persist($booking);
        $em->flush();

        return $this->json(['id' => $booking->getId()], 201);
    }

    #[Route('/bookings/create', name: 'booking_create_form', methods: ['POST'])]
    public function createFromForm(Request $request, EntityManagerInterface $em, DeskRepository $deskRepository): RedirectResponse
    {
        $data = $request->request->all();
        $desk = isset($data['desk_id']) ? $deskRepository->find($data['desk_id']) : null;
        if (!$desk) {
            $this->addFlash('error', 'Desk not found');
            return $this->redirectToRoute('home');
        }

        $booking = new Booking();
        $booking->setDesk($desk);
        $booking->setUser($data['user'] ?? '');
        $booking->setStartTime(new \DateTime($data['start_time'] ?? 'now'));
        $booking->setEndTime(new \DateTime($data['end_time'] ?? 'now'));

        $em->persist($booking);
        $em->flush();

        return $this->redirectToRoute('booking_list');
    }
}
