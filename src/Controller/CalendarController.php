<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Repository\CrossingRepository;
use App\Repository\NightRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CalendarController extends AbstractController
{
    #[Route('/dog/{id<\d+>}/calendar', name: 'show_calendar')]
    #[IsGranted('UPDATE', 'dog')]
    public function calendar(Dog $dog): Response
    {
        return $this->render('calendar/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/dog/{id<\d+>}/calendar/day/{date<\d{4}-\d{2}-\d{2}>}', name: 'show_calendar_day', defaults: ['date' => null])]
    #[IsGranted('UPDATE', 'dog')]
    public function today(Dog $dog, ?\DateTime $date, NightRepository $nightRepository, CrossingRepository $crossingRepository): Response
    {
        $date = $date ?? new \DateTime()->setTime(0, 0);

        return $this->render('calendar/day.html.twig', [
            'dog' => $dog,
            'night' => $nightRepository->findLastNightForDate($dog, $date),
            'crossings' => $crossingRepository->findForDate($dog, $date),
            'date' => $date,
        ]);
    }
}
