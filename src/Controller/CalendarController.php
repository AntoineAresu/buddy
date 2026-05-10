<?php

namespace App\Controller;

use App\Domain\Calendar\CalendarDataFormatter;
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
    public function calendar(Dog $dog, CalendarDataFormatter $formatter): Response
    {
        return $this->render('calendar/show.html.twig', [
            'dog' => $dog,
            'nights' => $formatter->getNightsCalendarData($dog),
            'crossings' => $formatter->getCrossingsCalendarData($dog),
        ]);
    }

    #[Route('/dog/{id<\d+>}/calendar/day/{date<\d{4}-\d{2}-\d{2}>}', name: 'show_calendar_day', defaults: ['date' => null])]
    #[IsGranted('UPDATE', 'dog')]
    public function day(Dog $dog, ?\DateTime $date, NightRepository $nightRepository, CrossingRepository $crossingRepository): Response
    {
        $date = $date ?? new \DateTime()->setTime(0, 0);
        $dateMinusOneDay = (clone $date)->sub(new \DateInterval('P1D'));
        $datePlusOneDay = (clone $date)->add(new \DateInterval('P1D'));

        return $this->render('calendar/day.html.twig', [
            'dog' => $dog,
            'night' => $nightRepository->findLastNightForDate($dog, $date),
            'crossings' => $crossingRepository->findForDate($dog, $date),
            'date' => $date,
            'datePlusOneDay' => $datePlusOneDay,
            'dateMinusOneDay' => $dateMinusOneDay,
        ]);
    }
}
