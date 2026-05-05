<?php

namespace App\Controller;

use App\Entity\Dog;
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
}
