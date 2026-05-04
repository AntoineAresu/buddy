<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'show_calendar')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function calendar(): Response
    {
        return $this->render('calendar/show.html.twig', [
            'dog' => $this->getUser()->getDogs()->first(),
        ]);
    }
}
