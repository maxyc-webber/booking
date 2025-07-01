<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\DeskRepository;
use App\Repository\BookingRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    public function create(Request $request, EntityManagerInterface $em, DeskRepository $deskRepository, BookingRepository $bookingRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $desk = isset($data['desk_id']) ? $deskRepository->find($data['desk_id']) : null;
        if (!$desk) {
            return $this->json(['error' => 'Desk not found'], 404);
        }

        if ($bookingRepository->findActiveForDesk($desk)) {
            return $this->json(['error' => 'Desk already booked'], 400);
        }

        $booking = new Booking();
        $booking->setDesk($desk);
        $booking->setUser($data['user'] ?? '');
        $booking->setPhone($data['phone'] ?? '');
        $booking->setStartTime(new \DateTimeImmutable());
        $booking->setEndTime((new \DateTimeImmutable())->modify('+20 minutes'));

        $em->persist($booking);
        $em->flush();

        return $this->json(['id' => $booking->getId()], 201);
    }

    #[Route('/bookings/create', name: 'booking_create_form', methods: ['POST'])]
    public function createFromForm(Request $request, EntityManagerInterface $em, DeskRepository $deskRepository, BookingRepository $bookingRepository, MailerInterface $mailer): RedirectResponse
    {
        $data = $request->request->all();
        if (!$this->isCsrfTokenValid('booking', $data['_token'] ?? '')) {
            $this->addFlash('error', 'Invalid CSRF token');
            return $this->redirectToRoute('home');
        }

        $desk = isset($data['desk_id']) ? $deskRepository->find($data['desk_id']) : null;
        if (!$desk) {
            $this->addFlash('error', 'Desk not found');
            return $this->redirectToRoute('home');
        }

        if ($bookingRepository->findActiveForDesk($desk)) {
            $this->addFlash('error', 'Desk already booked');
            return $this->redirectToRoute('home');
        }

        $booking = new Booking();
        $booking->setDesk($desk);
        $booking->setUser($data['user'] ?? '');
        $booking->setPhone($data['phone'] ?? '');
        $booking->setStartTime(new \DateTimeImmutable());
        $booking->setEndTime((new \DateTimeImmutable())->modify('+20 minutes'));

        $em->persist($booking);
        $em->flush();

        $email = (new Email())
            ->from('noreply@example.com')
            ->to('admin@example.com')
            ->subject('New booking')
            ->text(sprintf('Desk %s booked by %s (%s)', $desk->getName(), $booking->getUser(), $booking->getPhone()));
        $mailer->send($email);

        $this->addFlash('success', 'Desk booked successfully');
        return $this->redirectToRoute('home');
    }
}
